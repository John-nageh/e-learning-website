<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn)
    echo mysqli_connect_error();

if (!isset($_SESSION["i_id"])) {
    header("Location: ../registration/login.php");
}

$sql = "SELECT * FROM `instructor` WHERE i_id = " . $_SESSION['i_id'];
$result = mysqli_query($conn, $sql);
$result = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Admin Panel</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin_instructor_style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <main class="col-md-5 ms-sm-auto col-lg-10 content">
                <!-- Profile Section -->
                <section id="profile">
                    <h1>Instructor Profile</h1>
                    <div class="card">
                        <div class="card-body d-flex flex-column flex-lg-row justify-content-between align-items-center">
                            <!-- Profile Details (Left Side) -->
                            <div class="profile-details mb-3 mb-lg-0" style="padding-left:30px ;">
                                <h4 class="card-title text-danger" style="color: #C3413B ;"><?php echo $result['i_name']; ?></h4>
                                <p class="card-text">Email : <?php echo $result['i_email']; ?></p>
                                <p class="card-text">Phone : <?php echo $result['i_phone']; ?></p>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editProfileModal">Edit Profile</button>
                            </div>

                            <!-- Profile Photo (Right Side) -->
                            <div class="profile-photo">
                                <img src="../home/<?php echo $result['i_image']; ?>" alt="Profile Photo"
                                    class="img-fluid rounded-circle"
                                    style="width: 180px; height: 180px; object-fit: cover; margin-right: 100px;">
                            </div>
                        </div>
                    </div>
                </section>

                <hr>

                <!-- Courses Section -->
                <section id="courses">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Courses</h2>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add
                            Course</button>
                    </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Course Name</th>
                                <th>Image</th>
                                <th>Students</th>
                                <th>Price</th>
                                <th>Lessons</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `course` WHERE i_id = " . $_SESSION['i_id'];
                            $result2 = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($result2)) {
                                echo '
                                    <tr>
                                        <td>' . $row['c_id'] . '</td>
                                        <td>' . $row['c_name'] . '</td>
                                        <td><img src="../home/' . $row['c_image'] . '" class="course-image" alt="Course Image"></td>
                                        <td>';

                                $sql = "SELECT COUNT(s_id) as students FROM old_cart WHERE c_id = " . $row['c_id'];
                                $nm = mysqli_query($conn, $sql);
                                $nm = mysqli_fetch_array($nm);
                                echo $nm['students'];

                                echo '</td>
                                        <td>' . $row['c_price'] . '</td>
                                        <td>' . $row['c_no_of_lessons'] . '</td>
                                        <td>' . $row['c_level'] . '</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                onclick="editCourse(\'' . $row['c_name'] . '\', \'' . $row['c_price'] . '\', \'' . $row['c_no_of_lessons'] . '\', \'' . $row['c_level'] . '\', \'' . $row['c_id'] . '\', \'' . $row['c_image'] . '\')"
                                                class=".editCourseButton">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal"
                                                onclick="deleteCourse(\'' . $row['c_id'] . '\')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                    <div class="d-flex justify-content-center align-items-center" style="height: 50px;">
                        <a href="../registration/logout.php" class="btn btn-primary">Logout</a>
                    </div>

                </section>
            </main>
        </div>
    </div>


    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editProfileModalLabel">Edit Profile</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="mb-3 text-center">
                            <!-- Profile Photo Upload -->
                            <img id="profileImagePreview" src="../home/<?php echo $result['i_image']; ?>"
                                alt="Profile Photo" class="img-fluid rounded-circle"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-2">
                                <input type="file" class="form-control" id="profileImage" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="profileName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="profileName"
                                value="<?php echo $result['i_name']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="profileEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="profileEmail"
                                value="<?php echo $result['i_email']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="profilePhone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="profilePhone"
                                value="<?php echo $result['i_phone']; ?>">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="editProfile()">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // edit profile function
        function editProfile() {
            event.preventDefault(); // Prevent the default form submission

            // Extract form data
            const profileImage = document.getElementById('profileImage').files[0];
            const profileName = document.getElementById('profileName').value;
            const profileEmail = document.getElementById('profileEmail').value;
            const profilePhone = document.getElementById('profilePhone').value;

            // Use FormData to prepare the data
            const formData = new FormData();
            if (profileImage) {
                formData.append('profileImage', profileImage);
            }
            formData.append('profileName', profileName);
            formData.append('profileEmail', profileEmail);
            formData.append('profilePhone', profilePhone);

            // Send the data to the server
            fetch('update_profile.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error updating profile: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile.');
                });
        }
    </script>



    <!-- Add Course Modal -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addCourseModalLabel">Add Course</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCourseForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="courseName" required>
                        </div>
                        <div class="mb-3">
                            <label for="coursePrice" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="coursePrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseLessons" class="form-label">Lessons</label>
                            <input type="number" class="form-control" id="courseLessons" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseLevel" class="form-label">Level</label>
                            <select class="form-select" id="courseLevel" required>
                                <option value="Beginner" selected>Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="courseImage" class="form-label">Course Image</label>
                            <input type="file" class="form-control" id="courseImage" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="addCourse()">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // add course
        function addCourse() {
            event.preventDefault(); // Prevent the default form submission

            // Extract form data
            const courseImage = document.getElementById('courseImage').files[0];
            const courseName = document.getElementById('courseName').value;
            const coursePrice = document.getElementById('coursePrice').value;
            const courseLessons = document.getElementById('courseLessons').value;
            const courseLevel = document.getElementById('courseLevel').value;

            // Use FormData to prepare the data
            const formData = new FormData();
            if (courseImage) {
                formData.append('courseImage', courseImage);
            }
            formData.append('courseName', courseName);
            formData.append('coursePrice', coursePrice);
            formData.append('courseLessons', courseLessons);
            formData.append('courseLevel', courseLevel);

            // Send the data to the server
            fetch('add_course.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error updating profile: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the profile.');
                });
        }
    </script>



    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editCourseModalLabel">Edit Course</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="hideEditCourseModal()"></button>
                </div>

                <div class="modal-body">
                    <form id="editCourseForm">
                        <div class="mb-3 text-center">
                            <!-- Course Photo Upload -->
                            <img id="courseImagePreview" src="../home/images/course-3.jpg" alt="Course Photo"
                                class="img-fluid rounded" style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-2">
                                <input type="file" class="form-control" id="courseImageE" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="courseNameE" value="">
                        </div>
                        <div class="mb-3">
                            <label for="coursePrice" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="coursePriceE" value="">
                        </div>
                        <div class="mb-3">
                            <label for="courseLessons" class="form-label">Lessons</label>
                            <input type="number" class="form-control" id="courseLessonsE" value="Beginner">
                        </div>
                        <div class="mb-3">
                            <label for="courseLevel" class="form-label">Level</label>
                            <select class="form-select" id="courseLevelE">
                                <option value="Beginner" selected>Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="saveEditedCourse()">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Edit Course
        var c_id;
        function editCourse(name, price, lessons, level, id, image) {
            // alert(`Name: ${name}, Price: ${price}, Lessons: ${lessons}, Level: ${level}, ID: ${id}`);
            document.getElementById('courseNameE').value = name;
            document.getElementById('coursePriceE').value = price;
            document.getElementById('courseLessonsE').value = lessons;
            document.getElementById('courseLevelE').value = level;
            document.getElementById('courseImagePreview').src = '../home/' + image;

            const modal = document.getElementById('editCourseModal');

            // Make the modal visible
            modal.style.display = 'block';

            // Add the Bootstrap classes to show the modal
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');

            // Prevent background scrolling and enable backdrop
            document.body.classList.add('modal-open');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);

            c_id = id;
        }

        function hideEditCourseModal() {
            const modal = document.getElementById('editCourseModal');

            // Hide the modal
            modal.style.display = 'none';

            // Remove the Bootstrap classes
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            // Remove backdrop and background scrolling
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        }

        function saveEditedCourse(event) {
            // alert(`Name`);
            // event.preventDefault(); // Prevent default form submission

            // Gather form data
            const courseName = document.getElementById('courseNameE').value;
            const coursePrice = document.getElementById('coursePriceE').value;
            const courseLessons = document.getElementById('courseLessonsE').value;
            const courseLevel = document.getElementById('courseLevelE').value;
            const courseImage = document.getElementById('courseImageE').files[0];

            // Prepare form data for submission
            const formData = new FormData();
            formData.append('courseId', c_id);
            formData.append('courseName', courseName);
            formData.append('coursePrice', coursePrice);
            formData.append('courseLessons', courseLessons);
            formData.append('courseLevel', courseLevel);

            if (courseImage) {
                formData.append('courseImage', courseImage);
            }

            // Send the data to the server
            fetch('update_course.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Course updated successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error updating course: ' + data.message);
                    }
                })
        }
    </script>



    <!-- Confirmation Modal for Deletion -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        onclick="hideDeleteCourseModal()"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="hideDeleteCourseModal()">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton"
                        onclick="deleteCourseFromDatabase()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Delete course
        var c_id;
        function deleteCourse(id) {
            // alert(`ID: ${id}`);
            const modal = document.getElementById('confirmDeleteModal');

            // Make the modal visible
            modal.style.display = 'block';

            // Add the Bootstrap classes to show the modal
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');

            // Prevent background scrolling and enable backdrop
            document.body.classList.add('modal-open');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);

            c_id = id;
        }

        function hideDeleteCourseModal() {
            const modal = document.getElementById('confirmDeleteModal');

            // Hide the modal
            modal.style.display = 'none';

            // Remove the Bootstrap classes
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');

            // Remove backdrop and background scrolling
            document.body.classList.remove('modal-open');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        }

        function deleteCourseFromDatabase() {
            // Create a FormData object
            const formData = new FormData();
            formData.append('courseId', c_id);

            // Send the request to the server
            fetch('delete_course.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Course deleted successfully!');
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Error deleting course: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the course.');
                });
        }
    </script>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>