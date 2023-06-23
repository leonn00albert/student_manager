<div class="card m-3">
    <div class="card-header">Update CMS</div>
    <div class="card-body">
        <h4 class="card-title"></h4>
        <p class="card-text ">
        <div class="form-group">
            <form action="/admin/cms" method="POST">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $data["title"] ?>">
        </div>
        <div class="form-group">
            <label for="hero_image">Hero Image:</label>
            <input type="text" class="form-control" id="hero_image" name="hero_image" value="<?= $data["hero_image"] ?>">
        </div>
        <div class="form-group">
            <label for="hero_title">Hero Title:</label>
            <input type="text" class="form-control" id="hero_title" name="hero_title" value="<?= $data["hero_title"] ?>">
        </div>
        <div class="form-group">
            <label for="hero_text">Hero Text:</label>
            <textarea class="form-control" id="hero_text" name="hero_text"><?= $data["hero_text"] ?></textarea>
        </div>
        <div class="form-group">
            <label for="cta_text">CTA Text:</label>
            <input type="text" class="form-control" id="cta_text" name="cta_text" value="<?= $data["cta_text"] ?>">
        </div>
        <div class="form-group">
            <label for="cta_url">CTA URL:</label>
            <input type="text" class="form-control" id="cta_url" name="cta_url" value="<?= $data["cta_url"] ?>">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>