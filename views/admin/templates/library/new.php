<div class="card m-3">
    <div class="card-header">Add a new book</div>
    <div class="card-body">
        <form action="/admin/library" method="POST">
            <div class="form-group">
                <label for="bookId">Book Image url:</label>
                <input type="text" class="form-control" id="bookId" name="book_image" placeholder="Enter book ID">
            </div>
            <div class="form-group">
                <label for="bookTitle">Book Title:</label>
                <input type="text" class="form-control" id="bookTitle" name="book_title" placeholder="Enter book title">
            </div>
            <div class="form-group">
                <label for="bookURL">Book URL:</label>
                <input type="text" class="form-control" id="bookURL" name="book_url" placeholder="Enter book URL">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>