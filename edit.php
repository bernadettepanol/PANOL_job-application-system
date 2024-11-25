<?php
require 'dbConfig.php';
require 'models.php';

$applicant = new Engineer($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $data = [
        'firstName' => $_POST['firstName'],
        'lastName' => $_POST['lastName'],
        'yearsOfExperience' => $_POST['yearsOfExperience'],
        'skills' => $_POST['skills'],
        'preferredCompany' => $_POST['preferredCompany']
    ];
    $response = $applicant->update($id, $data);

    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$engineerData = $applicant->readById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Software Engineer</title>
</head>
<body>
    <header>
        Edit Software Engineer Applicant
    </header>
    <div>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?= $engineerData['id'] ?>">
            <label for="firstName">First Name:</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($engineerData['firstName']) ?>" required><br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" value="<?= htmlspecialchars($engineerData['lastName']) ?>" required><br>
            <label for="yearsOfExperience">Years of Experience:</label>
            <input type="number" name="yearsOfExperience" value="<?= htmlspecialchars($engineerData['yearsOfExperience']) ?>" required><br>
            <label for="skills">Skills:</label>
            <input type="text" name="skills" value="<?= htmlspecialchars($engineerData['skills']) ?>"><br>
            <label for="preferredCompany">Preferred Company:</label>
            <input type="text" name="preferredCompany" value="<?= htmlspecialchars($engineerData['preferredCompany']) ?>"><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
