<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "e_learning");
if (!$conn)
    echo mysqli_connect_error();

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

    <script>
        // Initialize Edit Course functionality
        var c_id;
        function editCourse(name, price, lessons, level, id) {
            alert(`Name: ${name}, Price: ${price}, Lessons: ${lessons}, Level: ${level}, ID: ${id}`);

            document.getElementById('courseNameE').value = name;
            document.getElementById('coursePriceE').value = price;
            document.getElementById('courseLessonsE').value = lessons;
            document.getElementById('courseLevelE').value = level;

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

            // c_id = id;
        }

        function hideConfirmDeleteModal() {
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

    </script>
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
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <!-- Profile Details (Left Side) -->
                            <div class="profile-details" style="padding-left:30px ;">
                                <h4 class="card-title" style="color: #C3413B ;"><?php echo $result['i_name']; ?></h4>
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

                <!-- <hr>

                Students Section
                <section id="students">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Students</h2>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add
                            Student</button>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Courses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Jane Smith</td>
                                <td>jane.smith@example.com</td>
                                <td>
                                    <select class="form-select" style="width: 250px;">
                                        <option value="Math">Web Development</option>
                                        <option value="Science">Node Js</option>
                                        <option value="History">React Native</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStudentModal">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Bob Johnson</td>
                                <td>bob.johnson@example.com</td>
                                <td>
                                    <select class="form-select" style="width: 250px;">
                                        <option value="History">React Native</option>
                                        <option value="Math">Web Development</option>
                                        <option value="Science">Node Js</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editStudentModal">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#confirmDeleteModal">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section> -->

                <hr>

                <!-- Courses Section -->
                <section id="courses">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Courses</h2>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCourseModal">Add
                            Course</button>
                    </div>
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
                                        <td>30</td>
                                        <td>' . $row['c_price'] . '</td>
                                        <td>' . $row['c_no_of_lessons'] . '</td>
                                        <td>' . $row['c_level'] . '</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm"
                                                data-bs-toggle="modal"
                                                onclick="editCourse(\'' . $row['c_name'] . '\', \'' . $row['c_price'] . '\', \'' . $row['c_no_of_lessons'] . '\', \'' . $row['c_level'] . '\', \'' . $row['c_id'] . '\')"
                                                class=".editCourseButton">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm" 
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ';
                            }
                            ?>
                        </tbody>
                    </table>
                </section>
            </main>
        </div>
    </div>

    <!-- Add Student Modal -->
    <!-- <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addStudentModalLabel">Add Student</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addStudentForm">
                        <div class="mb-3">
                            <label for="studentName" class="form-label">Name</label>
                            <input type="text" class="form-control" id="studentName">
                        </div>
                        <div class="mb-3">
                            <label for="studentEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="studentEmail">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div> -->

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
                            <input type="number" class="form-control" id="coursePrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseLessons" class="form-label">Lessons</label>
                            <input type="number" class="form-control" id="courseLessons" required>
                        </div>
                        <div class="mb-3">
                            <label for="courseLevel" class="form-label">Level</label>
                            <select class="form-select" id="courseLevel" required>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="courseImage" class="form-label">Course Image</label>
                            <input type="file" class="form-control" id="courseImage" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
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
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="editCourseModalLabel">Edit Course</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="hideConfirmDeleteModal()"></button>
                </div>

                <div class="modal-body">
                    <form id="editCourseForm">
                        <div class="mb-3 text-center">
                            <!-- Course Photo Upload -->
                            <img id="courseImagePreview" src="../home/images/course-3.jpg" alt="Course Photo"
                                class="img-fluid rounded" style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-2">
                                <input type="file" class="form-control" id="courseImage" accept="image/*">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="courseName" class="form-label">Course Name</label>
                            <input type="text" class="form-control" id="courseNameE" value="">
                        </div>
                        <div class="mb-3">
                            <label for="coursePrice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="coursePriceE" value="">
                        </div>
                        <div class="mb-3">
                            <label for="courseLessons" class="form-label">Lessons</label>
                            <input type="number" class="form-control" id="courseLessonsE" value="">
                        </div>
                        <div class="mb-3">
                            <label for="courseLevel" class="form-label">Level</label>
                            <select class="form-select" id="courseLevelE" value="">
                                <option value="beginner" selected>Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- submit code -->
    <script>
        // Main function to initialize the profile editing functionality
        function initializeProfileEditing() {
            const form = document.getElementById('editProfileForm');
            form.addEventListener('submit', handleFormSubmission);
        }
        // Function to handle form submission
        function handleFormSubmission(event) {
            event.preventDefault(); // Prevent the default form submission

            // Extract form data
            const profileImage = document.getElementById('profileImage').files[0];
            const profileName = document.getElementById('profileName').value;
            const profileEmail = document.getElementById('profileEmail').value;
            const profilePhone = document.getElementById('profilePhone').value;

            // Use FormData to prepare the data
            const formData = prepareFormData(profileImage, profileName, profileEmail, profilePhone);

            // Send the data to the server
            submitProfileData(formData);
        }
        // Function to prepare form data
        function prepareFormData(profileImage, profileName, profileEmail, profilePhone) {
            const formData = new FormData();
            if (profileImage) {
                formData.append('profileImage', profileImage);
            }
            formData.append('profileName', profileName);
            formData.append('profileEmail', profileEmail);
            formData.append('profilePhone', profilePhone);

            return formData;
        }
        // Function to send the form data to the server
        function submitProfileData(formData) {
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
        // Initialize the script
        initializeProfileEditing();



        // add course
        function initializeCourseAdding() {
            const form = document.getElementById('addCourseForm');
            form.addEventListener('submit', handleFormSubmission2);
        }
        // Function to handle form submission
        function handleFormSubmission2(event) {
            event.preventDefault(); // Prevent the default form submission

            // Extract form data
            const courseImage = document.getElementById('courseImage').files[0];
            const courseName = document.getElementById('courseName').value;
            const coursePrice = document.getElementById('coursePrice').value;
            const courseLessons = document.getElementById('courseLessons').value;
            const courseLevel = document.getElementById('courseLevel').value;

            // Use FormData to prepare the data
            const formData = prepareFormData2(courseImage, courseName, coursePrice, courseLessons, courseLevel);

            // Send the data to the server
            submitCourseData(formData);
        }
        // Function to prepare form data
        function prepareFormData2(courseImage, courseName, coursePrice, courseLessons, courseLevel) {
            const formData = new FormData();
            if (courseImage) {
                formData.append('courseImage', courseImage);
            }
            formData.append('courseName', courseName);
            formData.append('coursePrice', coursePrice);
            formData.append('courseLessons', courseLessons);
            formData.append('courseLevel', courseLevel);

            return formData;
        }
        // Function to send the form data to the server
        function submitCourseData(formData) {
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
        // Initialize the script
        initializeCourseAdding();
    </script>


    <!-- Confirmation Modal for Deletion -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>