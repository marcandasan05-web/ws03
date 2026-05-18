-- Run this in phpMyAdmin if you already imported an older database.sql
USE job_listing;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'employer') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT IGNORE INTO users (id, name, email, password, role) VALUES
(1, 'Alex Rivera', 'demo@rightjob.com', '$2y$10$T6CQUf9QSmhY6BB/fZIyiuhvIxFxbNdqzS7ELJTogzoNsDD0WxSwe', 'employer');

UPDATE listings SET user_id = 1 WHERE user_id IS NULL OR user_id = 0;

-- Add category column (run once; ignore error 1060 if column already exists)
-- ALTER TABLE listings ADD COLUMN category VARCHAR(50) DEFAULT NULL AFTER benefits;

UPDATE listings SET category = 'design-ux' WHERE title = 'Senior UX Designer';
UPDATE listings SET category = 'devops-cloud' WHERE title = 'Cloud DevOps Engineer';
UPDATE listings SET category = 'software-development' WHERE title IN ('Customer Success Manager', 'Full Stack Developer', 'HR Operations Specialist');
UPDATE listings SET category = 'data-ai' WHERE title = 'Digital Marketing Analyst';

INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, category, user_id)
SELECT * FROM (
    SELECT
        'Machine Learning Engineer' AS title,
        'DataCore AI is expanding its MLOps team to productionize recommendation models serving millions of users. You will own training pipelines, feature stores, and model monitoring in a modern Python stack.' AS description,
        '135000' AS salary,
        'python,pytorch,mlops,llm' AS tags,
        'DataCore AI' AS company,
        '42 Aurora Tower' AS address,
        'Makati' AS city,
        'NCR' AS state,
        '917-555-0201' AS phone,
        'talent@datacore.ai' AS email,
        'MS in CS or equivalent experience, PyTorch/TensorFlow proficiency, experience deploying models on AWS or GCP' AS requirements,
        'GPU lab access, conference budget, equity grant after year one' AS benefits,
        'data-ai' AS category,
        1 AS user_id
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM listings WHERE title = 'Machine Learning Engineer');

INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, category, user_id)
SELECT * FROM (
    SELECT
        'Cybersecurity Analyst' AS title,
        'ShieldNet Systems protects enterprise clients across banking and healthcare. Join the SOC team to investigate alerts, harden cloud workloads, and improve incident response playbooks.' AS description,
        '98000' AS salary,
        'soc,siem,cloud-security,incident-response' AS tags,
        'ShieldNet Systems' AS company,
        '9 Cyber Park Lane' AS address,
        'Taguig' AS city,
        'NCR' AS state,
        '932-555-0244' AS phone,
        'security@shieldnet.ph' AS email,
        '2+ years in security operations, familiarity with Splunk or Sentinel, knowledge of ISO 27001 controls' AS requirements,
        'Night-shift differential, certification sponsorship, 24/7 meal allowance' AS benefits,
        'cybersecurity' AS category,
        1 AS user_id
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM listings WHERE title = 'Cybersecurity Analyst');

INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, category, user_id)
SELECT * FROM (
    SELECT
        'React Native Mobile Developer' AS title,
        'AppForge Studio ships consumer apps for logistics and retail brands. Build performant cross-platform features, integrate REST APIs, and collaborate with designers on polished UI.' AS description,
        '92000' AS salary,
        'react-native,typescript,mobile,api' AS tags,
        'AppForge Studio' AS company,
        '18 Startup Row' AS address,
        'Cebu' AS city,
        'CEB' AS state,
        '905-555-0288' AS phone,
        'careers@appforge.studio' AS email,
        '3+ years mobile development, strong TypeScript, experience with App Store and Play Store releases' AS requirements,
        'MacBook Pro provided, flexible hybrid, quarterly hack days' AS benefits,
        'mobile' AS category,
        1 AS user_id
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM listings WHERE title = 'React Native Mobile Developer');

INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, category, user_id)
SELECT * FROM (
    SELECT
        'Site Reliability Engineer' AS title,
        'CloudPeak Technologies runs multi-region Kubernetes clusters for fintech APIs. Improve observability, define SLOs, and automate remediation for high-availability payment services.' AS description,
        '128000' AS salary,
        'sre,kubernetes,prometheus,go' AS tags,
        'CloudPeak Technologies' AS company,
        '500 BGC Corporate Center' AS address,
        'Taguig' AS city,
        'NCR' AS state,
        '918-555-0312' AS phone,
        'sre@cloudpeak.tech' AS email,
        'Experience with Kubernetes at scale, Go or Python for tooling, on-call experience in production environments' AS requirements,
        'Top-tier HMO, home internet stipend, performance bonus tied to uptime' AS benefits,
        'devops-cloud' AS category,
        1 AS user_id
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM listings WHERE title = 'Site Reliability Engineer');
