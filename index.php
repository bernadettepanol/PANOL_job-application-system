<?php
require 'dbConfig.php';
require 'models.php';

$applicant = new Engineer($pdo);
$applicants = [];
$message = "";
$statusCode = 200;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    switch ($action) {
        case 'create':
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'yearsOfExperience' => $_POST['yearsOfExperience'],
                'skills' => $_POST['skills'],
                'preferredCompany' => $_POST['preferredCompany']
            ];
            $response = $applicant->create($data);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
            break;

        case 'update':
            $id = $_POST['id'];
            $data = [
                'firstName' => $_POST['firstName'],
                'lastName' => $_POST['lastName'],
                'yearsOfExperience' => $_POST['yearsOfExperience'],
                'skills' => $_POST['skills'],
                'preferredCompany' => $_POST['preferredCompany']
            ];
            $response = $applicant->update($id, $data);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
            break;

        case 'delete':
            $id = $_POST['id'];
            $response = $applicant->delete($id);
            $message = $response['message'];
            $statusCode = $response['statusCode'];
            break;

        case 'search':
            $query = $_POST['query'];
            $response = $applicant->search($query);
            $applicants = $response['querySet'];
            if (count($applicants) > 0) {
                $message = "Found search.";
            } else {
                $message = "No applicant found.";
            }
            $statusCode = $response['statusCode'];
            break;

        default:
            $message = 'Invalid action.';
            $statusCode = 400;
            break;
    }
} else {
    $response = $applicant->read();
    $applicants = $response['querySet'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Engineer Applicant System</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse; 
        }
        th, td {
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left; 
        }
        th {
            background-color: #f2f2f2; 
        }
    </style>
</head>
<body>
    <h2>Add New Software Engineer Applicant</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="create">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" required><br>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" required><br>
        <label for="yearsOfExperience">Years of Experience:</label>
        <input type="number" name="yearsOfExperience" required><br>
        <label for="skills">Skills:</label>
        <input type="text" name="skills" required><br>
        <label for="preferredCompany">Preferred Company:</label>
        <input type="text" name="preferredCompany"><br>
        <input type="submit" value="Submit">
    </form>

    <h2>Search Applicants</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="search">
        <input type="text" name="query" placeholder="Search for applicants...">
        <input type="submit" value="Search">
    </form>

    <h2>Applicants Records</h2>
    <?php if ($message): ?>
        <div class="message">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($applicants)): ?>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Years of Experience</th>
                    <th>Skills</th>
                    <th>Preferred Company</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($applicants as $applicant): ?>
                    <tr>
                        <td><?= htmlspecialchars($applicant['firstName']) ?></td>
                        <td><?= htmlspecialchars($applicant['lastName']) ?></td>
                        <td><?= htmlspecialchars($applicant['yearsOfExperience']) ?></td>
                        <td><?= htmlspecialchars($applicant['skills']) ?></td>
                        <td><?= htmlspecialchars($applicant['preferredCompany']) ?></td>
                        <td>
                            <form action="delete.php" method="get" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $applicant['id'] ?>">
                                <input type="submit" value="Delete">
                            </form>
                            <form action="edit.php" method="get" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $applicant['id'] ?>">
                                <input type="submit" value="Edit">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
