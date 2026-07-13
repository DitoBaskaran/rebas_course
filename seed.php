<?php
// Seed database untuk REBAS COURSE
$host = 'localhost';
$db   = 'db_course_online';
$user = 'course_user';
$pass = 'Ditobaskaran123!@#';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "Koneksi database berhasil.\n";

    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    foreach (['minute_consumption_logs','minute_sessions','user_minute_balances','minute_bundles','user_subscriptions','package_items','packages','path_enrollments','learning_path_contents','learning_paths','quiz_attempts','quiz_questions','quizzes','submissions','assignments','certificates','reviews','discussion_replies','discussions','mentoring_sessions','content_tags','tags','progress','transactions','seminar_registrations','enrollments','lessons','courses','categories','seminars','translations','users'] as $t) {
        $pdo->exec("TRUNCATE TABLE $t;");
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "Berhasil mengosongkan semua tabel.\n";

    $pw = password_hash('password123', PASSWORD_BCRYPT);

    // ========== USERS ==========
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, bio, avatar, phone, language, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute(['Administrator', 'admin@rebas.com', $pw, 'admin', 'Founder & Lead Developer REBAS COURSE', '', '081234567890', 'id']);
    $stmt->execute(['Dimas Pratama, S.Kom.', 'dimas@rebas.com', $pw, 'teacher', 'Full-stack developer & mentor pemrograman sejak 2018', '', '081234567891', 'id']);
    $stmt->execute(['Sarah Wijaya, M.Pd.', 'sarah@rebas.com', $pw, 'teacher', 'Guru matematika & sains dengan pengalaman 10 tahun', '', '081234567892', 'id']);
    $stmt->execute(['Bryan Kusuma', 'bryan@rebas.com', $pw, 'teacher', 'Content creator & graphic designer profesional', '', '081234567893', 'id']);
    $stmt->execute(['Rian Pratama', 'rian@rebas.com', $pw, 'student', 'Mahasiswa yang suka belajar hal baru', '', '', 'id']);
    $stmt->execute(['Siti Nurhaliza', 'siti@rebas.com', $pw, 'student', 'Pelajar SMA yang ingin masuk PTN', '', '', 'id']);
    $stmt->execute(['John Doe', 'john@rebas.com', $pw, 'student', 'English learner interested in tech', '', '', 'en']);
    echo "Users OK.\n";

    $teachers = $pdo->query("SELECT id FROM users WHERE role='teacher'")->fetchAll();
    $teacher_dimas  = (int)$teachers[0]['id'];
    $teacher_sarah  = (int)$teachers[1]['id'];
    $teacher_bryan  = (int)$teachers[2]['id'];
    $students = $pdo->query("SELECT id FROM users WHERE role='student'")->fetchAll();
    $student_rian   = (int)$students[0]['id'];
    $student_siti   = (int)$students[1]['id'];
    $student_john   = (int)$students[2]['id'];

    // ========== CATEGORIES (multi-level) ==========
    $stmt = $pdo->prepare("INSERT INTO categories (parent_id, name, name_en, slug, description, description_en, icon, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([null, 'Pemrograman', 'Programming', 'programming', 'Belajar coding, web, mobile, AI, dan IT.', 'Learn coding, web, mobile, AI, and IT.', 'fas fa-laptop-code', 1]);
    $stmt->execute([null, 'Design & Kreatif', 'Design & Creative', 'design-kreatif', 'Desain grafis, UI/UX, video editing, animasi.', 'Graphic design, UI/UX, video editing, animation.', 'fas fa-palette', 2]);
    $stmt->execute([null, 'Bisnis & Entrepreneurship', 'Business & Entrepreneurship', 'bisnis-entrepreneurship', 'Strategi bisnis, marketing, keuangan, startup.', 'Business strategy, marketing, finance, startup.', 'fas fa-chart-line', 3]);
    $stmt->execute([null, 'Musik & Hobi', 'Music & Hobby', 'musik-hobi', 'Bermain alat musik, produksi musik, fotografi.', 'Play instruments, music production, photography.', 'fas fa-music', 4]);
    $stmt->execute([null, 'Soft Skills & Self Development', 'Soft Skills & Self Development', 'soft-skills', 'Public speaking, leadership, writing, mindfulness.', 'Public speaking, leadership, writing, mindfulness.', 'fas fa-brain', 5]);
    $stmt->execute([null, 'Bahasa', 'Language', 'bahasa', 'Kursus bahasa Inggris, Jepang, Korea, dan lainnya.', 'English, Japanese, Korean, and other language courses.', 'fas fa-language', 6]);

    $cats = $pdo->query("SELECT id, name FROM categories WHERE parent_id IS NULL")->fetchAll();
    $cat_prog = (int)$cats[0]['id'];
    $cat_design = (int)$cats[1]['id'];
    $cat_biz = (int)$cats[2]['id'];
    $cat_music = (int)$cats[3]['id'];
    $cat_soft = (int)$cats[4]['id'];
    $cat_lang = (int)$cats[5]['id'];

    // Subcategories
    $stmt->execute([$cat_prog, 'Web Development', 'Web Development', 'web-dev', 'HTML, CSS, JavaScript, React, Laravel', 'HTML, CSS, JavaScript, React, Laravel', 'fas fa-globe', 1]);
    $stmt->execute([$cat_prog, 'Mobile App', 'Mobile App', 'mobile-app', 'Flutter, React Native, Swift, Kotlin', 'Flutter, React Native, Swift, Kotlin', 'fas fa-mobile-alt', 2]);
    $stmt->execute([$cat_prog, 'Data Science & AI', 'Data Science & AI', 'data-science-ai', 'Python, Machine Learning, Deep Learning', 'Python, Machine Learning, Deep Learning', 'fas fa-robot', 3]);
    $stmt->execute([$cat_design, 'Graphic Design', 'Graphic Design', 'graphic-design', 'Photoshop, Illustrator, Canva, branding', 'Photoshop, Illustrator, Canva, branding', 'fas fa-paint-brush', 1]);
    $stmt->execute([$cat_design, 'UI/UX Design', 'UI/UX Design', 'ui-ux-design', 'Figma, wireframing, prototyping, user research', 'Figma, wireframing, prototyping, user research', 'fas fa-drafting-compass', 2]);
    $stmt->execute([$cat_design, 'Video & Animation', 'Video & Animation', 'video-animasi', 'Premiere Pro, After Effects, Blender', 'Premiere Pro, After Effects, Blender', 'fas fa-film', 3]);

    $subcats = $pdo->query("SELECT id, name FROM categories WHERE parent_id IS NOT NULL")->fetchAll();
    $sub_web = (int)$subcats[0]['id'];
    $sub_mobile = (int)$subcats[1]['id'];
    $sub_data = (int)$subcats[2]['id'];
    $sub_gd = (int)$subcats[3]['id'];
    $sub_uiux = (int)$subcats[4]['id'];
    $sub_video = (int)$subcats[5]['id'];
    echo "Categories OK.\n";

    // ========== TAGS ==========
    $stmt = $pdo->prepare("INSERT INTO tags (name, name_en, slug) VALUES (?, ?, ?)");
    $tags_list = [
        ['Pemula', 'Beginner', 'beginner'],
        ['Lanjutan', 'Advanced', 'advanced'],
        ['Proyek Nyata', 'Real Project', 'real-project'],
        ['Studi Kasus', 'Case Study', 'case-study'],
        ['Sertifikat', 'Certificate', 'certificate'],
        ['Gratis', 'Free', 'free'],
        ['Populer', 'Popular', 'popular'],
        ['Terbaru', 'Newest', 'newest'],
        ['Python', 'Python', 'python'],
        ['JavaScript', 'JavaScript', 'javascript'],
        ['React', 'React', 'react'],
        ['Figma', 'Figma', 'figma'],
        ['Excel', 'Excel', 'excel'],
        ['Gitar', 'Guitar', 'guitar'],
        ['IELTS', 'IELTS', 'ielts'],
    ];
    $tag_ids = [];
    foreach ($tags_list as $t) {
        $stmt->execute($t);
        $tag_ids[] = (int)$pdo->lastInsertId();
    }
    echo "Tags OK.\n";

    // ========== COURSES ==========
    $stmt = $pdo->prepare("INSERT INTO courses (category_id, teacher_id, title, title_en, slug, content_type, skill_level, price, description, description_en, thumbnail, duration_total, language, featured, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    
    // 1. Web Dev: Laravel API (course)
    $slug = 'laravel-api-restful';
    $stmt->execute([$sub_web, $teacher_dimas, 'Membangun REST API dengan Laravel', 'Build REST API with Laravel', $slug, 'course', 'intermediate', 150000, 'Pelajari cara membangun REST API yang scalable menggunakan Laravel. Dari authentication dengan Sanctum, routing, controller, hingga deployment.', 'Learn to build scalable REST APIs using Laravel. From Sanctum authentication, routing, controllers, to deployment.', 'laravel_api.png', 480, 'id', 1, 'published']);
    $course_1 = (int)$pdo->lastInsertId();
    
    // 2. Web Dev: HTML/CSS (course) - free beginner
    $stmt->execute([$sub_web, $teacher_dimas, 'HTML & CSS untuk Pemula', 'HTML & CSS for Beginners', 'html-css-pemula', 'course', 'beginner', 0, 'Belajar HTML5 dan CSS3 dari nol. Buat website pertamamu dengan panduan langkah demi langkah.', 'Learn HTML5 and CSS3 from scratch. Build your first website with step-by-step guidance.', 'html_css.png', 300, 'id', 1, 'published']);
    $course_2 = (int)$pdo->lastInsertId();

    // 3. Data Science: Python (bootcamp)
    $stmt->execute([$sub_data, $teacher_dimas, 'Python Data Science Bootcamp', 'Python Data Science Bootcamp', 'python-data-science-bootcamp', 'bootcamp', 'beginner', 350000, 'Bootcamp intensif Python untuk Data Science. Coverage: NumPy, Pandas, Matplotlib, Scikit-learn, dan final project end-to-end.', 'Intensive Python for Data Science bootcamp. Covers: NumPy, Pandas, Matplotlib, Scikit-learn, and end-to-end final project.', 'python_bootcamp.png', 1200, 'id', 0, 'published']);
    $course_3 = (int)$pdo->lastInsertId();

    // 4. Graphic Design: Canva (workshop)
    $stmt->execute([$sub_gd, $teacher_bryan, 'Canva Masterclass: Desain Grafis Tanpa Ribet', 'Canva Masterclass: Effortless Graphic Design', 'canva-masterclass', 'workshop', 'beginner', 75000, 'Workshop Canva untuk pemula. Pelajari desain konten sosial media, presentasi, logo, dan mockup dengan template siap pakai.', 'Canva workshop for beginners. Learn social media design, presentations, logos, and mockups with ready-to-use templates.', 'canva_workshop.png', 180, 'id', 1, 'published']);
    $course_4 = (int)$pdo->lastInsertId();

    // 5. UI/UX: Figma (ebook)
    $stmt->execute([$sub_uiux, $teacher_bryan, 'Ebook: UI/UX Design dengan Figma', 'Ebook: UI/UX Design with Figma', 'ebook-figma-uiux', 'ebook', 'intermediate', 50000, 'Ebook PDF 120 halaman tentang UI/UX design menggunakan Figma. Termasuk komponen, auto layout, prototyping, dan design system.', '120-page PDF ebook on UI/UX design using Figma. Includes components, auto layout, prototyping, and design systems.', 'figma_ebook.png', 240, 'id', 0, 'published']);
    $course_5 = (int)$pdo->lastInsertId();

    // 6. Video & Animation: Adobe Premiere (video)
    $stmt->execute([$sub_video, $teacher_bryan, 'Video Editing dengan Premiere Pro', 'Video Editing with Premiere Pro', 'premiere-pro-editing', 'video', 'intermediate', 0, 'Kumpulan video tutorial editing video menggunakan Adobe Premiere Pro. Dari cutting dasar hingga color grading dan motion graphics.', 'Video tutorial series for editing with Adobe Premiere Pro. From basic cutting to color grading and motion graphics.', 'premiere_video.png', 360, 'id', 0, 'published']);
    $course_6 = (int)$pdo->lastInsertId();

    // 7. Music: Gitar (course)
    $stmt->execute([$cat_music, $teacher_bryan, 'Belajar Gitar dari Nol', 'Learn Guitar from Zero', 'belajar-gitar-dasar', 'course', 'beginner', 100000, 'Kursus gitar lengkap dari dasar: chord, strumming, fingerstyle, membaca tablature, hingga lagu populer.', 'Complete guitar course from basics: chords, strumming, fingerstyle, reading tablature, to popular songs.', 'guitar_course.png', 600, 'id', 0, 'published']);
    $course_7 = (int)$pdo->lastInsertId();

    // 8. Language: IELTS (course)
    $stmt->execute([$cat_lang, $teacher_sarah, 'IELTS Preparation: Band 7+', 'IELTS Preparation: Band 7+', 'ielts-preparation', 'course', 'advanced', 200000, 'Persiapan IELTS lengkap: Listening, Reading, Writing, Speaking. Tips, trik, simulasi tes, dan koreksi writing.', 'Complete IELTS preparation: Listening, Reading, Writing, Speaking. Tips, tricks, test simulation, and writing correction.', 'ielts_course.png', 900, 'en', 1, 'published']);
    $course_8 = (int)$pdo->lastInsertId();

    echo "Courses OK.\n";

    // ========== CONTENT TAGS ==========
    $content_tags_data = [
        [$course_1, $tag_ids[0]], // laravel + beginer
        [$course_1, $tag_ids[6]], // laravel + popular
        [$course_1, $tag_ids[7]], // laravel + terbaru
        [$course_2, $tag_ids[0]], // html + pemula
        [$course_2, $tag_ids[5]], // html + gratis
        [$course_2, $tag_ids[6]], // html + populer
        [$course_2, $tag_ids[7]], // html + terbaru
        [$course_2, $tag_ids[9]], // html + javascript
        [$course_3, $tag_ids[0]], // python + pemula
        [$course_3, $tag_ids[2]], // python + proyek nyata
        [$course_3, $tag_ids[4]], // python + sertifikat
        [$course_3, $tag_ids[8]], // python + python
        [$course_4, $tag_ids[0]], // canva + pemula
        [$course_4, $tag_ids[5]], // canva + gratis... oops not free
        [$course_4, $tag_ids[6]], // canva + populer
        [$course_5, $tag_ids[1]], // figma + advanced
        [$course_5, $tag_ids[11]], // figma + figma
        [$course_6, $tag_ids[0]], // premiere + pemula
        [$course_6, $tag_ids[5]], // premiere + free
        [$course_7, $tag_ids[0]], // gitar + pemula
        [$course_7, $tag_ids[13]], // gitar + guitar
        [$course_8, $tag_ids[1]], // ielts + advanced
        [$course_8, $tag_ids[14]], // ielts
    ];
    $stmt = $pdo->prepare("INSERT INTO content_tags (content_id, tag_id) VALUES (?, ?)");
    foreach ($content_tags_data as $ct) {
        $stmt->execute($ct);
    }
    echo "Content Tags OK.\n";

    // ========== LESSONS ==========
    $stmt = $pdo->prepare("INSERT INTO lessons (course_id, title, title_en, lesson_type, description, description_en, content, video_url, duration, sort_order, is_free, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    // Course 2 HTML/CSS (free) - 5 lessons
    $stmt->execute([$course_2, 'Apa itu HTML?', 'What is HTML?', 'video', 'Pengenalan HTML, struktur dasar, dan tools yang dibutuhkan.', 'Introduction to HTML, basic structure, and required tools.', '', 'https://www.youtube.com/watch?v=UB1O30fR-EE', 10, 1, 1]);
    $stmt->execute([$course_2, 'Tag HTML Dasar', 'Basic HTML Tags', 'text', 'Belajar tag heading, paragraf, link, gambar, dan list.', 'Learn heading, paragraph, link, image, and list tags.', 'Heading: h1-h6\nParagraf: p\nLink: a href=\nGambar: img src=\nList: ul/ol & li', '', 15, 2, 1]);
    $stmt->execute([$course_2, 'Pengenalan CSS', 'Introduction to CSS', 'video', 'Cara menambahkan CSS ke HTML: inline, internal, external.', 'How to add CSS to HTML: inline, internal, external.', '', 'https://www.youtube.com/watch?v=1PnVor36_40', 12, 3, 1]);
    $stmt->execute([$course_2, 'CSS Flexbox & Grid', 'CSS Flexbox & Grid', 'text', 'Layout modern dengan Flexbox dan CSS Grid.', 'Modern layout with Flexbox and CSS Grid.', 'Flexbox: display:flex; justify-content; align-items\nGrid: display:grid; grid-template-columns; gap', '', 20, 4, 1]);
    $stmt->execute([$course_2, 'Proyek: Landing Page', 'Project: Landing Page', 'assignment', 'Buat landing page sederhana dengan HTML & CSS.', 'Build a simple landing page with HTML & CSS.', 'Buat halaman landing page untuk produk fiktif. Sertakan: header, hero section, fitur, footer.', '', 45, 5, 1]);

    // Course 1 Laravel API (paid, intermediate) - 4 lessons
    $stmt->execute([$course_1, 'Setup & Routing', 'Setup & Routing', 'video', 'Instalasi Laravel, struktur folder, dan basic routing.', 'Laravel installation, folder structure, and basic routing.', '', 'https://www.youtube.com/watch?v=ImtZ5yENzgE', 20, 1, 0]);
    $stmt->execute([$course_1, 'Controller & Model', 'Controller & Model', 'video', 'Membuat controller, model, migration, dan Eloquent ORM.', 'Creating controllers, models, migrations, and Eloquent ORM.', '', '', 25, 2, 0]);
    $stmt->execute([$course_1, 'API Authentication with Sanctum', 'API Auth with Sanctum', 'video', 'Implementasi token-based authentication menggunakan Laravel Sanctum.', 'Implement token-based authentication using Laravel Sanctum.', '', '', 30, 3, 0]);
    $stmt->execute([$course_1, 'Quiz: Laravel Fundamentals', 'Quiz: Laravel Fundamentals', 'quiz', 'Tes pemahaman dasar Laravel dan REST API.', 'Test understanding of Laravel and REST API fundamentals.', '', '', 15, 4, 0]);

    echo "Lessons OK.\n";

    // ========== QUIZZES ==========
    $stmt = $pdo->prepare("INSERT INTO quizzes (course_id, title, title_en, description, description_en, time_limit, max_attempts, passing_score, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$course_1, 'Kuis Laravel Dasar', 'Basic Laravel Quiz', 'Uji pemahamanmu tentang Laravel framework.', 'Test your understanding of the Laravel framework.', 15, 3, 70]);
    $quiz_1 = (int)$pdo->lastInsertId();
    $stmt->execute([$course_2, 'Kuis HTML & CSS', 'HTML & CSS Quiz', 'Tes pengetahuan HTML dan CSS dasar.', 'Test basic HTML and CSS knowledge.', 10, 2, 60]);
    $quiz_2 = (int)$pdo->lastInsertId();

    // Quiz Questions (JSON options)
    $stmt = $pdo->prepare("INSERT INTO quiz_questions (quiz_id, question_type, question, question_en, options, options_en, correct_answer, points, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Q1: Laravel (multiple choice)
    $stmt->execute([$quiz_1, 'multiple_choice',
        'Apa perintah untuk membuat controller di Laravel?',
        'What is the command to create a controller in Laravel?',
        json_encode(['php artisan make:controller', 'php artisan create:controller', 'php artisan new:controller', 'php artisan generate:controller']),
        json_encode(['php artisan make:controller', 'php artisan create:controller', 'php artisan new:controller', 'php artisan generate:controller']),
        'php artisan make:controller', 20, 1]);
    $stmt->execute([$quiz_1, 'multiple_choice',
        'ORM bawaan Laravel adalah...',
        'Laravel\'s built-in ORM is...',
        json_encode(['Eloquent', 'Doctrine', 'Hibernate', 'ActiveRecord']),
        json_encode(['Eloquent', 'Doctrine', 'Hibernate', 'ActiveRecord']),
        'Eloquent', 20, 2]);
    $stmt->execute([$quiz_1, 'true_false',
        'Laravel menggunakan arsitektur MVC.',
        'Laravel uses MVC architecture.',
        json_encode(['True', 'False']), json_encode(['True', 'False']),
        'True', 10, 3]);
    $stmt->execute([$quiz_1, 'short_answer',
        'Sebutkan 3 jenis relationship di Eloquent!',
        'Name 3 types of relationships in Eloquent!',
        '[]', '[]',
        'oneToMany,manyToMany,hasOne', 25, 4]);

    // Q2: HTML & CSS (multiple choice)
    $stmt->execute([$quiz_2, 'multiple_choice',
        'Tag HTML manakah yang digunakan untuk membuat hyperlink?',
        'Which HTML tag is used to create a hyperlink?',
        json_encode(['<a>', '<link>', '<href>', '<url>']),
        json_encode(['<a>', '<link>', '<href>', '<url>']),
        '<a>', 25, 1]);
    $stmt->execute([$quiz_2, 'multiple_choice',
        'CSS property apa yang digunakan untuk mengubah warna teks?',
        'Which CSS property is used to change text color?',
        json_encode(['color', 'font-color', 'text-color', 'background-color']),
        json_encode(['color', 'font-color', 'text-color', 'background-color']),
        'color', 25, 2]);
    $stmt->execute([$quiz_2, 'true_false',
        'Flexbox adalah layout satu dimensi.',
        'Flexbox is a one-dimensional layout.',
        json_encode(['True', 'False']), json_encode(['True', 'False']),
        'True', 25, 3]);
    $stmt->execute([$quiz_2, 'short_answer',
        'Apa kepanjangan dari CSS?',
        'What does CSS stand for?',
        '[]', '[]',
        'Cascading Style Sheets', 25, 4]);
    echo "Quizzes & Questions OK.\n";

    // ========== ASSIGNMENTS ==========
    $stmt = $pdo->prepare("INSERT INTO assignments (course_id, title, title_en, description, description_en, max_score, due_days, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$course_2, 'Buat Halaman HTML Pertamamu', 'Build Your First HTML Page', 'Buat file HTML dengan: header, 3 paragraf, 2 gambar, dan 1 link ke Google.', 'Create an HTML file with: a header, 3 paragraphs, 2 images, and 1 link to Google.', 100, 7]);
    $stmt->execute([$course_4, 'Desain Poster Media Sosial', 'Design a Social Media Poster', 'Buat desain poster promosi untuk event fiktif menggunakan Canva. Ukuran 1080x1080 px.', 'Create a promotional poster design for a fictional event using Canva. Size 1080x1080 px.', 100, 7]);
    echo "Assignments OK.\n";

    // ========== LEARNING PATHS ==========
    $stmt = $pdo->prepare("INSERT INTO learning_paths (title, title_en, slug, description, description_en, category_id, color, skill_level, estimated_hours, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute(['Full-Stack Web Developer', 'Full-Stack Web Developer', 'full-stack-web-dev', 'Jalur belajar menjadi full-stack web developer dari nol hingga mahir. Coverage: HTML, CSS, JavaScript, Laravel, dan React.', 'Learning path to become a full-stack web developer from zero to proficient. Covers: HTML, CSS, JavaScript, Laravel, and React.', $cat_prog, '#4361ee', 'beginner', 120]);
    $lp_1 = (int)$pdo->lastInsertId();
    $stmt->execute(['Data Analyst Career Track', 'Data Analyst Career Track', 'data-analyst-track', 'Jalur karir menjadi data analyst. Pelajari Excel, SQL, Python, Tableau, dan statistik.', 'Career track to become a data analyst. Learn Excel, SQL, Python, Tableau, and statistics.', $cat_prog, '#f72585', 'intermediate', 150]);
    $lp_2 = (int)$pdo->lastInsertId();

    // Learning Path Contents
    $stmt = $pdo->prepare("INSERT INTO learning_path_contents (path_id, course_id, sort_order) VALUES (?, ?, ?)");
    $stmt->execute([$lp_1, $course_2, 1]); // HTML/CSS first
    $stmt->execute([$lp_1, $course_1, 2]); // Laravel next
    $stmt->execute([$lp_2, $course_3, 1]); // Python bootcamp
    echo "Learning Paths OK.\n";

    // ========== CERTIFICATES ==========
    $stmt = $pdo->prepare("INSERT INTO certificates (user_id, course_id, title, title_en, certificate_code, issued_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$student_rian, $course_2, 'HTML & CSS untuk Pemula', 'HTML & CSS for Beginners', 'CERT-' . strtoupper(substr(md5(uniqid()), 0, 10))]);
    echo "Certificates OK.\n";

    // ========== ENROLLMENTS ==========
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id, enrolled_at) VALUES (?, ?, NOW())");
    $stmt->execute([$student_rian, $course_2]); // free html/css
    $stmt->execute([$student_rian, $course_3]); // paid python (enroll now, transaction later)
    $stmt->execute([$student_siti, $course_2]); // html/css
    $stmt->execute([$student_siti, $course_4]); // canva
    $stmt->execute([$student_john, $course_8]); // ielts
    $stmt->execute([$student_john, $course_1]); // laravel
    echo "Enrollments OK.\n";

    // ========== PATH ENROLLMENTS ==========
    $stmt = $pdo->prepare("INSERT INTO path_enrollments (user_id, path_id) VALUES (?, ?)");
    $stmt->execute([$student_rian, $lp_1]);
    echo "Path Enrollments OK.\n";

    // ========== PROGRESS (mark first lesson completed for Rian) ==========
    $lessons_c2 = $pdo->query("SELECT id FROM lessons WHERE course_id = $course_2 ORDER BY sort_order LIMIT 2")->fetchAll();
    $stmt = $pdo->prepare("INSERT INTO progress (user_id, lesson_id, status, completed_at) VALUES (?, ?, 'completed', NOW())");
    $stmt->execute([$student_rian, (int)$lessons_c2[0]['id']]);
    $stmt->execute([$student_rian, (int)$lessons_c2[1]['id']]);
    echo "Progress OK.\n";

    // ========== REVIEWS ==========
    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, course_id, rating, review, review_en, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$student_rian, $course_2, 5, 'Kelasnya sangat bagus untuk pemula! Penjelasannya mudah dipahami.', 'Great class for beginners! The explanation is easy to understand.',]);
    $stmt->execute([$student_siti, $course_2, 4, 'Materinya lengkap, tapi videonya agak kurang banyak.', 'Complete material, but could use more videos.',]);
    $stmt->execute([$student_john, $course_8, 5, 'Excellent IELTS preparation course! Highly recommended.', 'Kelas persiapan IELTS yang luar biasa! Sangat direkomendasikan.',]);
    echo "Reviews OK.\n";

    // ========== DISCUSSIONS ==========
    $stmt = $pdo->prepare("INSERT INTO discussions (course_id, user_id, title, content, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$course_2, $student_rian, 'CSS Grid vs Flexbox, kapan pakai yang mana?', 'Saya masih bingung kapan harus menggunakan Grid dan kapan Flexbox. Mohon penjelasannya!']);
    $disc_1 = (int)$pdo->lastInsertId();
    $stmt->execute([$course_2, $student_siti, 'Error: file HTML tidak muncul gambarnya', 'Saya sudah pakai tag img tapi gambar tidak muncul di browser. Kenapa ya?']);
    $disc_2 = (int)$pdo->lastInsertId();

    // Replies
    $stmt = $pdo->prepare("INSERT INTO discussion_replies (discussion_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$disc_1, $teacher_dimas, 'Gunakan Flexbox untuk layout satu dimensi (baris/kolom). Gunakan Grid untuk layout dua dimensi (baris dan kolom sekaligus).']);
    $stmt->execute([$disc_2, $teacher_dimas, 'Periksa: 1) Nama file benar? 2) Path gambar benar? 3) Format gambar didukung browser?']);
    echo "Discussions & Replies OK.\n";

    // ========== MENTORING SESSIONS ==========
    $stmt = $pdo->prepare("INSERT INTO mentoring_sessions (mentor_id, student_id, scheduled_at, topic, topic_en, status, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([$teacher_dimas, $student_rian, date('Y-m-d H:i:s', strtotime('+2 days 14:00')), 'Konsultasi: Memilih framework frontend terbaik untuk portfolio', 'Consultation: Choosing the best frontend framework for portfolio', 'scheduled']);
    $stmt->execute([$teacher_dimas, $student_siti, date('Y-m-d H:i:s', strtotime('-1 day 10:00')), 'Review portfolio HTML/CSS', 'HTML/CSS portfolio review', 'completed']);
    echo "Mentoring OK.\n";

    // ========== TRANSACTIONS ==========
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, item_type, item_id, amount, status, payment_proof, created_at) VALUES (?, ?, ?, ?, 'approved', 'seed_proof.png', NOW())");
    $stmt->execute([$student_rian, 'course', $course_3, 350000]);
    echo "Transactions OK.\n";

    // ========== PACKAGES (Subscription Tiers) ==========
    $stmt = $pdo->prepare("INSERT INTO packages (name, name_en, slug, description, description_en, price, duration_days, discount_6mo, access_scope, is_active, sort_order, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute(['Basic', 'Basic', 'basic', 'Akses ke kategori Pemrograman & Web Development.', 'Access to Programming & Web Development categories.', 100000, 30, 0, 'category', 1, 1]);
    $pkg_basic = (int)$pdo->lastInsertId();
    $stmt->execute(['Premium', 'Premium', 'premium', 'Akses ke SEMUA kategori dan konten premium. Termasuk kursus, workshop, bootcamp, dan ebook.', 'Access to ALL categories and premium content. Includes courses, workshops, bootcamps, and ebooks.', 250000, 30, 10.00, 'all', 1, 2]);
    $pkg_premium = (int)$pdo->lastInsertId();
    $stmt->execute(['Master', 'Master', 'master', 'Akses tak terbatas ke semua konten + mentoring prioritas + sertifikat gratis.', 'Unlimited access to all content + priority mentoring + free certificates.', 500000, 90, 16.67, 'all', 1, 3]);
    $pkg_master = (int)$pdo->lastInsertId();
    echo "Packages OK.\n";

    // Package Items (category-based access)
    $stmt = $pdo->prepare("INSERT INTO package_items (package_id, item_type, item_id) VALUES (?, ?, ?)");
    $stmt->execute([$pkg_basic, 'category', $cat_prog]); // Programming
    $sub_web = (int)$pdo->query("SELECT id FROM categories WHERE slug='web-dev'")->fetchColumn(); // fetch it again for safety
    $sub_mobile = (int)$pdo->query("SELECT id FROM categories WHERE slug='mobile-app'")->fetchColumn();
    $sub_data = (int)$pdo->query("SELECT id FROM categories WHERE slug='data-science-ai'")->fetchColumn();
    $stmt->execute([$pkg_basic, 'category', $sub_web]);
    $stmt->execute([$pkg_basic, 'category', $sub_mobile]);
    $stmt->execute([$pkg_basic, 'category', $sub_data]);
    echo "Package Items OK.\n";

    // ========== MINUTE BUNDLES ==========
    $stmt = $pdo->prepare("INSERT INTO minute_bundles (name, name_en, minutes, price, is_active, sort_order, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute(['30 Menit', '30 Minutes', 30, 25000, 1, 1]);
    $stmt->execute(['60 Menit', '60 Minutes', 60, 45000, 1, 2]);
    $stmt->execute(['120 Menit', '120 Minutes', 120, 80000, 1, 3]);
    $stmt->execute(['300 Menit', '300 Minutes', 300, 175000, 1, 4]);
    $stmt->execute(['600 Menit', '600 Minutes', 600, 300000, 1, 5]);
    echo "Minute Bundles OK.\n";

    // ========== USER MINUTE BALANCES (sample) ==========
    $stmt = $pdo->prepare("INSERT INTO user_minute_balances (user_id, balance_seconds, total_purchased_seconds, total_used_seconds, updated_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$student_rian, 7200, 7200, 0]); // Rian has 120 minutes
    echo "User Minute Balances OK.\n";

    // ========== USER SUBSCRIPTIONS (sample) ==========
    $stmt = $pdo->prepare("INSERT INTO user_subscriptions (user_id, package_id, status, started_at, expires_at, created_at) VALUES (?, ?, 'active', NOW(), DATE_ADD(NOW(), INTERVAL ? DAY), NOW())");
    $stmt->execute([$student_siti, $pkg_premium, 30]); // Siti has premium
    echo "User Subscriptions OK.\n";

    // ========== TRANSLATIONS ==========
    $stmt = $pdo->prepare("INSERT INTO translations (`key`, value_id, value_en) VALUES (?, ?, ?)");
    $trans = [
        ['Jelajahi', 'Jelajahi', 'Explore'],
        ['Semua Konten', 'Semua Konten', 'All Content'],
        ['Tambah ke Keranjang', 'Tambah ke Keranjang', 'Add to Cart'],
        ['Belajar Sekarang', 'Belajar Sekarang', 'Start Learning'],
        ['Lihat Detail', 'Lihat Detail', 'View Details'],
        ['Rating', 'Rating', 'Rating'],
        ['Total Siswa', 'Total Siswa', 'Total Students'],
        ['Total Materi', 'Total Materi', 'Total Lessons'],
    ];
    foreach ($trans as $t) {
        $stmt->execute($t);
    }
    echo "Translations OK.\n";

    // ========== SETTINGS ==========
    $settings_table_check = $pdo->query("SHOW TABLES LIKE 'settings'")->fetchColumn();
    if (!$settings_table_check) {
        $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `key` VARCHAR(100) UNIQUE NOT NULL,
            `value` TEXT NULL,
            `type` VARCHAR(50) DEFAULT 'text',
            `group` VARCHAR(50) DEFAULT 'general',
            `label` VARCHAR(255) DEFAULT '',
            `sort_order` INT DEFAULT 0
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    $pdo->exec("DELETE FROM settings");
    $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`, `type`, `group`, `label`, `sort_order`) VALUES (?, ?, ?, ?, ?, ?)");

    $seed_settings = [
        // General
        ['general_site_name', 'REBAS COURSE', 'text', 'general', 'Site Name', 1],
        ['general_site_description', 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.', 'textarea', 'general', 'Site Description', 2],
        ['general_site_keywords', 'belajar online, kursus, seminar, workshop, bootcamp, e-book', 'text', 'general', 'Site Keywords', 3],
        ['general_site_logo', '', 'image', 'general', 'Site Logo', 4],
        ['general_site_favicon', '', 'image', 'general', 'Favicon', 5],
        ['general_admin_email', 'admin@rebas.com', 'email', 'general', 'Admin Email', 6],
        ['general_contact_email', 'support@rebascourse.com', 'email', 'general', 'Contact Email', 7],
        ['general_contact_phone', '021-1234-5678', 'text', 'general', 'Contact Phone', 8],
        ['general_contact_address', 'Jakarta, Indonesia', 'textarea', 'general', 'Address', 9],

        // Appearance
        ['appearance_primary_color', '#0d6efd', 'color', 'appearance', 'Primary Color', 1],
        ['appearance_secondary_color', '#6c757d', 'color', 'appearance', 'Secondary Color', 2],
        ['appearance_accent_color', '#6366f1', 'color', 'appearance', 'Accent Color', 3],
        ['appearance_body_font', '', 'text', 'appearance', 'Body Font Family', 4],
        ['appearance_heading_font', '', 'text', 'appearance', 'Heading Font Family', 5],

        // Hero
        ['hero_enabled', '1', 'boolean', 'hero', 'Enable Hero Section', 1],
        ['hero_badge', 'Platform Belajar Skill #1', 'text', 'hero', 'Hero Badge Text', 2],
        ['hero_badge_en', '#1 Skill Learning Platform', 'text', 'hero', 'Hero Badge Text (English)', 3],
        ['hero_title', 'Belajar <span class="text-warning">Skill</span> Apapun, Kapanpun', 'textarea', 'hero', 'Hero Title', 4],
        ['hero_title_en', 'Learn <span class="text-warning">Any Skill</span>, Anytime', 'textarea', 'hero', 'Hero Title (English)', 5],
        ['hero_subtitle', 'Akses ribuan konten belajar terstruktur: programming, desain, bisnis, soft skill, musik, dan banyak lagi. Dari pemula hingga mahir.', 'textarea', 'hero', 'Hero Subtitle', 6],
        ['hero_subtitle_en', 'Access thousands of structured learning content: programming, design, business, soft skills, music, and more.', 'textarea', 'hero', 'Hero Subtitle (English)', 7],
        ['hero_cta_text', 'Cari Konten', 'text', 'hero', 'Hero CTA Text', 8],
        ['hero_cta_text_en', 'Browse Content', 'text', 'hero', 'Hero CTA Text (English)', 9],
        ['hero_cta_link', 'courses', 'text', 'hero', 'Hero CTA Link', 10],
        ['hero_secondary_cta_text', 'Skill Tree', 'text', 'hero', 'Hero Secondary CTA Text', 11],
        ['hero_secondary_cta_text_en', 'Skill Tree', 'text', 'hero', 'Hero Secondary CTA Text (English)', 12],
        ['hero_secondary_cta_link', 'learning_paths', 'text', 'hero', 'Hero Secondary CTA Link', 13],

        // Homepage
        ['home_show_stats', '1', 'boolean', 'homepage', 'Show Stats Strip', 1],
        ['home_show_categories', '1', 'boolean', 'homepage', 'Show Categories Section', 2],
        ['home_show_featured', '1', 'boolean', 'homepage', 'Show Featured Section', 3],
        ['home_show_recent', '1', 'boolean', 'homepage', 'Show Recent Content Section', 4],
        ['home_show_tags', '1', 'boolean', 'homepage', 'Show Popular Tags', 5],
        ['home_show_seminars', '1', 'boolean', 'homepage', 'Show Seminars Section', 6],
        ['home_show_cta', '1', 'boolean', 'homepage', 'Show CTA Section', 7],
        ['home_featured_count', '4', 'number', 'homepage', 'Number of Featured Items', 8],
        ['home_recent_count', '6', 'number', 'homepage', 'Number of Recent Items', 9],
        ['home_cta_title', 'Siap Menguasai Skill Baru?', 'text', 'homepage', 'CTA Title', 10],
        ['home_cta_title_en', 'Ready to Master a New Skill?', 'text', 'homepage', 'CTA Title (English)', 11],
        ['home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.', 'textarea', 'homepage', 'CTA Subtitle', 12],
        ['home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.', 'textarea', 'homepage', 'CTA Subtitle (English)', 13],
        ['home_cta_button_text', 'Daftar Gratis', 'text', 'homepage', 'CTA Button Text', 14],
        ['home_cta_button_text_en', 'Register Free', 'text', 'homepage', 'CTA Button Text (English)', 15],
        ['home_cta_button_link', 'auth/register', 'text', 'homepage', 'CTA Button Link', 16],

        // Social
        ['social_facebook', '#', 'url', 'social', 'Facebook URL', 1],
        ['social_instagram', '#', 'url', 'social', 'Instagram URL', 2],
        ['social_youtube', '#', 'url', 'social', 'YouTube URL', 3],
        ['social_tiktok', '#', 'url', 'social', 'TikTok URL', 4],
        ['social_whatsapp', '#', 'url', 'social', 'WhatsApp URL', 5],
        ['social_twitter', '#', 'url', 'social', 'Twitter URL', 6],
        ['social_linkedin', '#', 'url', 'social', 'LinkedIn URL', 7],

        // Footer
        ['footer_about_text', 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.', 'textarea', 'footer', 'Footer About Text', 1],
        ['footer_about_text_en', 'Modern online learning platform with structured classes and interactive seminars from Indonesia\'s best experts.', 'textarea', 'footer', 'Footer About Text (English)', 2],
        ['footer_copyright', 'REBAS COURSE. All rights reserved.', 'text', 'footer', 'Copyright Text', 3],

        // Payment / Pakasir
        ['pakasir_slug', '', 'text', 'payment', 'Pakasir Project Slug', 1],
        ['pakasir_api_key', '', 'text', 'payment', 'Pakasir API Key', 2],
        ['pakasir_sandbox', '1', 'boolean', 'payment', 'Pakasir Sandbox Mode', 3],
    ];

    foreach ($seed_settings as $s) {
        $stmt->execute($s);
    }
    echo "Settings OK.\n";

    echo "\n✓ SEMUA DATA SEEDER BERHASIL!\n";
    echo "  Admin: admin@rebas.com / password123\n";
    echo "  Teacher: dimas@rebas.com / password123\n";
    echo "  Teacher: sarah@rebas.com / password123\n";
    echo "  Teacher: bryan@rebas.com / password123\n";
    echo "  Student: rian@rebas.com / password123\n";
    echo "  Student: siti@rebas.com / password123\n";
    echo "  Student: john@rebas.com / password123\n";

} catch (PDOException $e) {
    echo "Kesalahan database: " . $e->getMessage() . "\n";
}
