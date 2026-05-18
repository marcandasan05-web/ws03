CREATE DATABASE IF NOT EXISTS job_listing;
USE job_listing;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'employer') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS listings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    salary VARCHAR(50) NOT NULL,
    tags VARCHAR(255) DEFAULT NULL,
    company VARCHAR(255) DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(50) NOT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    email VARCHAR(255) NOT NULL,
    requirements TEXT DEFAULT NULL,
    benefits TEXT DEFAULT NULL,
    category VARCHAR(50) DEFAULT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Safe to re-run: skips insert if demo@rightjob.com already exists
INSERT IGNORE INTO users (name, email, password, role) VALUES
('Alex Rivera', 'demo@rightjob.com', '$2y$10$T6CQUf9QSmhY6BB/fZIyiuhvIxFxbNdqzS7ELJTogzoNsDD0WxSwe', 'employer');

INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, category, user_id) VALUES
('Senior UX Designer', 'RightJob partner NovaBridge Labs is hiring a UX lead to shape mobile and web experiences for fintech products used across Southeast Asia.', '105000', 'ux,design,fintech,remote', 'NovaBridge Labs', '88 Harbor Point', 'Manila', 'NCR', '917-555-0142', 'careers@novabridge.io', '5+ years in product design, strong Figma portfolio, experience with design systems', 'Hybrid schedule, HMO + dependents, annual learning budget', 'design-ux', 1),
('Cloud DevOps Engineer', 'Build and maintain CI/CD pipelines for a growing SaaS platform. You will work closely with backend teams to improve deployment reliability.', '120000', 'devops,aws,kubernetes', 'Skyline Digital', '210 Tech Park Ave', 'Cebu', 'CEB', '932-555-0198', 'talent@skylinedigital.com', 'AWS certification preferred, Terraform experience, on-call rotation readiness', 'Stock options, remote Fridays, premium health coverage', 'devops-cloud', 1),
('Customer Success Manager', 'Own client relationships post-sale and drive retention for our B2B analytics dashboard. Ideal for communicators who love data.', '78000', 'saas,customer-success,b2b', 'MetricFlow', '14 Union Plaza', 'Davao', 'DAV', '905-555-0111', 'hello@metricflow.co', '2+ years in account management, CRM proficiency, excellent presentation skills', 'Performance bonuses, flexible PTO, mentorship program', 'software-development', 1),
('Full Stack Developer', 'Join a product squad shipping features end-to-end using PHP, JavaScript, and MySQL. Greenfield modules ahead.', '95000', 'php,javascript,fullstack', 'RightJob Labs', '5 Innovation Hub', 'Quezon City', 'NCR', '918-555-0177', 'jobs@rightjob.app', 'Solid OOP fundamentals, REST API experience, Git workflow comfort', 'Work-from-home stipend, team offsites, certification reimbursement', 'software-development', 1),
('Digital Marketing Analyst', 'Plan campaigns, analyze funnel metrics, and optimize ad spend across search and social channels for employer brands.', '68000', 'marketing,analytics,seo', 'BrightHire Media', '33 Media Row', 'Baguio', 'BEN', '927-555-0133', 'growth@brighthire.media', 'Google Analytics certified, A/B testing experience, content strategy basics', 'Creative Fridays, co-working allowance, health & wellness fund', 'data-ai', 1),
('HR Operations Specialist', 'Support recruitment operations, onboarding, and policy documentation for a distributed workforce.', '62000', 'hr,operations,recruitment', 'PeopleFirst Co.', '120 Civic Center', 'Iloilo', 'ILI', '909-555-0166', 'people@peoplefirst.co', 'HRIS familiarity, strong organizational skills, employment law awareness', 'Four-day work week trial, shuttle service, family day events', 'software-development', 1),
('Machine Learning Engineer', 'DataCore AI is expanding its MLOps team to productionize recommendation models serving millions of users. You will own training pipelines, feature stores, and model monitoring in a modern Python stack.', '135000', 'python,pytorch,mlops,llm', 'DataCore AI', '42 Aurora Tower', 'Makati', 'NCR', '917-555-0201', 'talent@datacore.ai', 'MS in CS or equivalent experience, PyTorch/TensorFlow proficiency, experience deploying models on AWS or GCP', 'GPU lab access, conference budget, equity grant after year one', 'data-ai', 1),
('Cybersecurity Analyst', 'ShieldNet Systems protects enterprise clients across banking and healthcare. Join the SOC team to investigate alerts, harden cloud workloads, and improve incident response playbooks.', '98000', 'soc,siem,cloud-security,incident-response', 'ShieldNet Systems', '9 Cyber Park Lane', 'Taguig', 'NCR', '932-555-0244', 'security@shieldnet.ph', '2+ years in security operations, familiarity with Splunk or Sentinel, knowledge of ISO 27001 controls', 'Night-shift differential, certification sponsorship, 24/7 meal allowance', 'cybersecurity', 1),
('React Native Mobile Developer', 'AppForge Studio ships consumer apps for logistics and retail brands. Build performant cross-platform features, integrate REST APIs, and collaborate with designers on polished UI.', '92000', 'react-native,typescript,mobile,api', 'AppForge Studio', '18 Startup Row', 'Cebu', 'CEB', '905-555-0288', 'careers@appforge.studio', '3+ years mobile development, strong TypeScript, experience with App Store and Play Store releases', 'MacBook Pro provided, flexible hybrid, quarterly hack days', 'mobile', 1),
('Site Reliability Engineer', 'CloudPeak Technologies runs multi-region Kubernetes clusters for fintech APIs. Improve observability, define SLOs, and automate remediation for high-availability payment services.', '128000', 'sre,kubernetes,prometheus,go', 'CloudPeak Technologies', '500 BGC Corporate Center', 'Taguig', 'NCR', '918-555-0312', 'sre@cloudpeak.tech', 'Experience with Kubernetes at scale, Go or Python for tooling, on-call experience in production environments', 'Top-tier HMO, home internet stipend, performance bonus tied to uptime', 'devops-cloud', 1);
