<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    public function index()
    {
        $query = 'SELECT * FROM listings WHERE 1=1';
        $params = [];

        $keywords = trim($_GET['keywords'] ?? '');
        $location = trim($_GET['location'] ?? '');
        $category = trim($_GET['category'] ?? '');
        $allowedCategories = array_keys(jobCategories());

        if ($category !== '' && !in_array($category, $allowedCategories, true)) {
            $category = '';
        }

        if ($keywords !== '') {
            $query .= ' AND (title LIKE :keywords OR description LIKE :keywords OR tags LIKE :keywords OR company LIKE :keywords)';
            $params['keywords'] = '%' . $keywords . '%';
        }

        if ($location !== '') {
            $query .= ' AND (city LIKE :location OR state LIKE :location OR address LIKE :location)';
            $params['location'] = '%' . $location . '%';
        }

        if ($category !== '') {
            $query .= ' AND category = :category';
            $params['category'] = $category;
        }

        $query .= ' ORDER BY created_at DESC';

        $listings = $this->db->query($query, $params)->fetchAll();

        loadView('listings/index', [
            'pageTitle' => 'Browse Jobs — RightJob',
            'listings' => $listings,
            'keywords' => $keywords,
            'location' => $location,
            'category' => $category,
        ]);
    }

    public function create()
    {
        requireEmployer();

        loadView('listings/create', [
            'pageTitle' => 'Post a Position — RightJob',
            'listing' => [],
        ]);
    }

    public function show($params)
    {
        $listing = $this->findListing($params['id'] ?? '');

        if (!$listing) {
            ErrorController::notFound('This position could not be found.');
            return;
        }

        loadView('listings/show', [
            'pageTitle' => e($listing->title) . ' — RightJob',
            'listing' => $listing,
            'canManage' => $this->canManage($listing),
        ]);
    }

    public function store()
    {
        requireEmployer();

        $result = $this->validateListing($_POST);

        if (!empty($result['errors'])) {
            loadView('listings/create', [
                'pageTitle' => 'Post a Position — RightJob',
                'errors' => $result['errors'],
                'listing' => $result['data'],
            ]);
            return;
        }

        $data = $result['data'];
        $data['user_id'] = currentUserId();
        $this->insertListing($data);

        setFlash('success_message', 'Your job posting is now live on RightJob.');
        redirect('/listings');
    }

    public function edit($params)
    {
        requireEmployer();

        $listing = $this->findListing($params['id'] ?? '');

        if (!$listing) {
            ErrorController::notFound('This position could not be found.');
            return;
        }

        if (!$this->canManage($listing)) {
            ErrorController::unauthorized('You can only edit your own postings.');
            return;
        }

        loadView('listings/edit', [
            'pageTitle' => 'Edit Position — RightJob',
            'listing' => $listing,
        ]);
    }

    public function update($params)
    {
        requireEmployer();

        $id = $params['id'] ?? '';
        $listing = $this->findListing($id);

        if (!$listing) {
            ErrorController::notFound('This position could not be found.');
            return;
        }

        if (!$this->canManage($listing)) {
            ErrorController::unauthorized('You can only edit your own postings.');
            return;
        }

        $result = $this->validateListing($_POST);

        if (!empty($result['errors'])) {
            loadView('listings/edit', [
                'pageTitle' => 'Edit Position — RightJob',
                'errors' => $result['errors'],
                'listing' => (object) array_merge((array) $listing, $result['data']),
            ]);
            return;
        }

        $data = $result['data'];
        $data['id'] = $id;

        $sets = [];
        foreach (array_keys($data) as $field) {
            if ($field !== 'id') {
                $sets[] = "{$field} = :{$field}";
            }
        }

        $this->db->query(
            'UPDATE listings SET ' . implode(', ', $sets) . ' WHERE id = :id',
            $data
        );

        setFlash('success_message', 'Job posting updated successfully.');
        redirect('/listings/' . $id);
    }

    public function destroyForm($params)
    {
        requireEmployer();

        $listing = $this->findListing($params['id'] ?? '');

        if (!$listing) {
            ErrorController::notFound('This position could not be found.');
            return;
        }

        if (!$this->canManage($listing)) {
            ErrorController::unauthorized('You can only delete your own postings.');
            return;
        }

        loadView('listings/delete', [
            'pageTitle' => 'Confirm Delete — RightJob',
            'listing' => $listing,
            'errors' => [],
        ]);
    }

    public function destroy($params)
    {
        requireEmployer();

        $id = $params['id'] ?? '';
        $listing = $this->findListing($id);

        if (!$listing) {
            ErrorController::notFound('This position could not be found.');
            return;
        }

        if (!$this->canManage($listing)) {
            ErrorController::unauthorized('You can only delete your own postings.');
            return;
        }

        $password = $_POST['password'] ?? '';

        if (!Validation::string($password, 1)) {
            loadView('listings/delete', [
                'pageTitle' => 'Confirm Delete — RightJob',
                'listing' => $listing,
                'errors' => ['password' => 'Please enter your password to confirm deletion.'],
            ]);
            return;
        }

        if (!$this->verifyUserPassword($password)) {
            loadView('listings/delete', [
                'pageTitle' => 'Confirm Delete — RightJob',
                'listing' => $listing,
                'errors' => ['password' => 'Incorrect password. Deletion was not completed.'],
            ]);
            return;
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', ['id' => $id]);

        setFlash('success_message', 'Job posting removed successfully.');
        redirect('/listings');
    }

    protected function verifyUserPassword(string $password): bool
    {
        $user = $this->db->query(
            'SELECT password FROM users WHERE id = :id',
            ['id' => currentUserId()]
        )->fetch();

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password);
    }

    protected function findListing($id)
    {
        if ($id === '' || !ctype_digit((string) $id)) {
            return null;
        }

        return $this->db->query(
            'SELECT * FROM listings WHERE id = :id',
            ['id' => $id]
        )->fetch();
    }

    protected function canManage($listing): bool
    {
        if (!isEmployer()) {
            return false;
        }

        return (int) $listing->user_id === currentUserId();
    }

    protected function validateListing(array $input): array
    {
        $allowedFields = [
            'title', 'description', 'salary', 'tags', 'company',
            'address', 'city', 'state', 'phone', 'email',
            'requirements', 'benefits',
        ];

        $data = array_intersect_key($input, array_flip($allowedFields));
        $data = array_map('sanitize', $data);

        $requiredFields = ['title', 'description', 'salary', 'email', 'city', 'state'];
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field]) || !Validation::string($data[$field])) {
                $errors[$field] = ucfirst($field) . ' is required.';
            }
        }

        if (!empty($data['email']) && !Validation::email($data['email'])) {
            $errors['email'] = 'Please enter a valid email address.';
        }

        foreach ($data as $field => $value) {
            if ($value === '') {
                $data[$field] = null;
            }
        }

        return ['errors' => $errors, 'data' => $data];
    }

    protected function insertListing(array $data): void
    {
        $fields = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(fn($f) => ':' . $f, array_keys($data)));

        $this->db->query(
            "INSERT INTO listings ({$fields}) VALUES ({$placeholders})",
            $data
        );
    }
}
