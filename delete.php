<?php
require 'dbConfig.php';
require 'models.php';

$applicant = new Engineer($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $id = $_POST['id'];
        $response = $applicant->delete($id);

        header("Location: index.php");
        exit;
    } else {
        header("Location: index.php");
        exit;
    }
}

$id = $_GET['id'];
$engineerData = $applicant->readById($id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Software Engineer</title>
</head>
<body>
    <header>
        Delete Software Engineer Applicant
    </header>
    <div>
        <p>Are you sure you want to delete the following applicant?</p>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($engineerData['id']) ?>">
            <p>First Name: <?= htmlspecialchars($engineerData['firstName']) ?></p>
            <p>Last Name: <?= htmlspecialchars($engineerData['lastName']) ?></p>
            <p>Years of Experience: <?= htmlspecialchars($engineerData['yearsOfExperience']) ?></p>
            <p>Skills: <?= htmlspecialchars($engineerData['skills']) ?></p>
            <p>Preferred Company: <?= htmlspecialchars($engineerData['preferredCompany']) ?></p>
            <p>
                <label for="confirm">Do you want to delete this software engineer applicant?</label><br>
                <input type="radio" name="confirm" value="yes"> Yes<br>
                <input type="radio" name="confirm" value="no" checked> No<br>
            </p>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>

