<div class="row">
    <div class="col">
        <div class="card m-3">
            <div class="card-header">Module: <?= $module["module_name"] ?></div>
            <div class="card-body">
    
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card m-3">
            <div class="card-header">Topics</div>
            <div class="card-body">
                <ul class="list-group">  
                    <?php foreach ($sections as $section) : ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= $section["section_id"] ?>: <?= $section["section_name"] ?>
                        <a href="/students/sections/<?= $section["section_id"] ?>" class="btn btn-primary">Go to Section</a>  
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>