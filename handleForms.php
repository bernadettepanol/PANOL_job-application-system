<?php
require 'dbConfig.php';
require 'models.php';

$applicant = new Engineer($pdo);

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
            break;

        case 'delete':
            $id = $_POST['id'];
            $response = $applicant->delete($id);
            break;

        case 'search':
            $query = $_POST['query'];
            $response = ['querySet' => $applicant->search($query), 'statusCode' => 200];
            break;

        default:
            $response = ['message' => 'Invalid action.', 'statusCode' => 400];
            break;
    }

    echo json_encode($response);
}
?>
