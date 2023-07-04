<div class="card m-3">
    <div class="card-header">Books</div>
    <div class="card-body">

        <h4 class="card-title"><span class="badge bg-primary m-1" id="courseCount"></span></h4>
        <p class="card-text">
        <div class="table-responsive-md">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Registration number</th>
                        <th scope="col">Book title<i onclick="handleSort('country')" class="fa fa-sort"></i></th>
                        <th scope="col">image <i onclick="handleSort('name')" class="fa fa-sort"></i></th>
                        <th scope="col">download location<i onclick="handleSort('grade')" class="fa fa-sort"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book) : ?>
                        <tr>
                            <td>
                                <?= $book["book_id"] ?>
                            </td>
                            <td>
                                <?= $book["book_title"] ?>
                            </td>
              
                            <td>
                                <img src=<?= $book["book_image"] ?>  width="50="/>
                            </td>
                            <td>
                            <a href="<?= $book["book_url"] ?>" >Download</a>
                            </td>
             
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>