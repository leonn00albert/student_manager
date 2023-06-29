<div class="row row-cols-2">
    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class="fa fa-cubes" aria-hidden="true"></i> Module: <?= $module["module_name"] ?></div>
            <div class="card-body">
                <ul class="list-group">
                    <a href="/students/sections/<?= $section["section_id"] ?>" class="list-group-item disabled  list-group-item-secondary  d-flex align-items-center" style="  background-color: var(--bs-card-cap-bg);">
                        <i class="fa me-1 fa-list-alt" aria-hidden="true"></i> Sections:
                    </a>
                    <?php $section_id_unqiue = null; ?>
                    <?php foreach ($sections as $section) : ?>
                        <?php
                        if ($section_id_unqiue != $section["section_id"]) {
                            if ($section["grade_status"] === "Graded") { ?>
                                <a href="/students/sections/<?= $section["section_id"] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span>
                                        <i class="fa fa-solid fa-check-square-o "></i>
                                        <?= $section["section_name"] ?>
                                    </span>
                                </a>
                            <?php  } else { ?>
                                <a href="/students/sections/<?= $section["section_id"] ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <?= $section["section_name"] ?>

                                </a>
                        <?php  }
                        } ?>

                    <?php
                        $section_id_unqiue = $section["section_id"];
                    endforeach; ?>
                </ul>
            </div>
        </div>
    </div>


    <div class="col">
        <div class="card m-3">
            <div class="card-header"><i class="fa  fa-send" aria-hidden="true"></i> Assignments Submitted</div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($sections as $section) : ?>

                        <?php if ($section["grade_status"] === "Graded") { ?>
                            <li class="list-group-item  d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fa fa-solid fa-check-square-o "></i>
                                    <?= $section["section_name"] ?> - <?= $section["score"] ?> - <?= $section["grade_status"] ?>
                                </span>
                                <a href="/students/grades/<?= $section["grade_id"] ?>" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            <?php  } else if ($section["grade_status"] === "Pending") { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">

                                <?= $section["section_name"] ?> - <?= $section["grade_status"] ?>
                                <a href="/students/grades/<?= $section["grade_id"] ?>" class="btn btn-primary"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </li>
                        <?php  } ?>

                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>