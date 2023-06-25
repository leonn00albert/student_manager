<div class="card m-3">
    <div class="card-header">Update User</div>
    <div class="card-body">
        <form id="updateForm">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value=<?= $first_name ?> required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value=<?= $last_name ?> required>
            </div>
            <div class="form-group">
                <label for="contact_email">Contact Email:</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value=<?= $contact_email ?> required>
            </div>
            <div class="form-group">
                <label for="contact_phone">Contact Phone:</label>
                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value=<?= $contact_phone ?> required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address" name="address" value=<?= $address ?> required>
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" id="city" name="city" value=<?= $city ?> required>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" class="form-control" id="country" name="country" value=<?= $country ?> required>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value=<?= $date_of_birth ?> required>
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" id="gender" name="gender" value=<?= $gender ?> required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('updateForm');
    form.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const jsonData = {};

        formData.forEach((value, key) => {
            jsonData[key] = value;
        });

        fetch(`/users/<?=$user_id ?>`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                if (response.ok) {
                    console.log('User updated successfully');
                } else {
                    console.error('User update failed');
                }
            })
            .catch(error => {
                console.error('An error occurred:', error);
            });
    });
</script>