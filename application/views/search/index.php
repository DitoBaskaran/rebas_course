<div class="container py-5 my-4">
    <div class="row mb-5 animate-fade-in-up">
        <div class="col-lg-8">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Pencarian</span>
            <h1 class="display-5 fw-extrabold text-dark mb-2 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Hasil Pencarian', 'Search Results'); ?></h1>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem;">
                <?php echo count($results); ?> <?php echo t('hasil ditemukan', 'results found'); ?>
                <?php if ($q): ?>untuk "<strong><?php echo htmlspecialchars($q); ?></strong>"<?php endif; ?>
            </p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Filters -->
        <div class="col-lg-3 animate-fade-in-up">
            <div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
                <h6 class="fw-bold text-dark mb-4"><i class="fas fa-sliders-h me-2"></i><?php echo t('Filter', 'Filters'); ?></h6>
                <form action="<?php echo base_url('search'); ?>" method="GET">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark"><?php echo t('Kata Kunci', 'Keyword'); ?></label>
                        <input type="text" name="q" class="form-control rounded-pill" value="<?php echo htmlspecialchars($q ?? ''); ?>" placeholder="<?php echo t('Cari...', 'Search...'); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark"><?php echo t('Tipe Konten', 'Content Type'); ?></label>
                        <select name="type" class="form-select rounded-pill">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <?php foreach ($content_types as $ct): ?>
                                <option value="<?php echo $ct; ?>" <?php echo ($selected_type ?? '') === $ct ? 'selected' : ''; ?>><?php echo content_type_label($ct); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark"><?php echo t('Level', 'Level'); ?></label>
                        <select name="level" class="form-select rounded-pill">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <?php foreach ($skill_levels as $sl): ?>
                                <option value="<?php echo $sl; ?>" <?php echo ($selected_level ?? '') === $sl ? 'selected' : ''; ?>><?php echo skill_level_label($sl); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-dark"><?php echo t('Kategori', 'Category'); ?></label>
                        <select name="category" class="form-select rounded-pill">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat->id; ?>" <?php echo ($selected_category ?? '') == $cat->id ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-2 rounded-pill fw-semibold"><?php echo t('Cari', 'Search'); ?></button>
                </form>

                <?php if (!empty($tags)): ?>
                    <hr class="my-4">
                    <h6 class="fw-bold text-dark mb-3"><?php echo t('Tags Populer', 'Popular Tags'); ?></h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag): ?>
                            <a href="<?php echo base_url('search?tag=' . $tag->id); ?>" class="badge bg-light text-secondary text-decoration-none rounded-pill px-3 py-2 fw-medium border"><?php echo htmlspecialchars($tag->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Results -->
        <div class="col-lg-9 animate-fade-in-up stagger-1">
            <div class="row g-4">
                <?php if (empty($results)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-search fs-3 text-secondary"></i>
                            </div>
                            <h5 class="fw-bold text-dark"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
                            <p class="text-secondary small mb-0"><?php echo t('Tidak ada hasil ditemukan. Coba kata kunci lain.', 'No results found. Try different keywords.'); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($results as $course): ?>
                        <div class="col-md-6 animate-fade-in-up">
                            <div class="card h-100 border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column" style="transition: all 0.3s ease;">
                                <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                                    <div class="position-absolute top-0 start-0 m-3 d-flex gap-2 flex-wrap">
                                        <span class="badge bg-dark text-white rounded-pill px-3 py-2 shadow-sm fw-medium"><?php echo content_type_label($course->content_type); ?></span>
                                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 shadow-sm fw-medium"><?php echo skill_level_label($course->skill_level); ?></span>
                                    </div>
                                </div>
                                <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                    <h5 class="fw-bold text-dark mb-2 lh-sm" style="font-size: 1.15rem;"><?php echo htmlspecialchars($course->title); ?></h5>
                                    <p class="text-secondary small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($course->description); ?></p>
                                    <div class="mt-auto pt-3 border-top border-light d-flex align-items-center justify-content-between">
                                        <span class="fs-5 fw-bold text-dark"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="text-success">' . t('Gratis', 'Free') . '</span>'; ?></span>
                                        <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold"><?php echo t('Detail', 'Detail'); ?> <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
