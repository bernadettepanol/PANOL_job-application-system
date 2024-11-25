<?php
class Engineer {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($data) {
        
        $sql = "SELECT COUNT(*) FROM software_engineer_applicants WHERE 
                firstName = :firstName AND lastName = :lastName AND preferredCompany = :preferredCompany";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'preferredCompany' => $data['preferredCompany']
        ]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return ['message' => 'Duplicate applicant. Already exists for this company.', 'statusCode' => 400];
        }

        $sql = "INSERT INTO software_engineer_applicants (firstName, lastName, yearsOfExperience, skills, preferredCompany)
                VALUES (:firstName, :lastName, :yearsOfExperience, :skills, :preferredCompany)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute($data)) {
            return ['message' => 'Applicant added successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to add applicant.', 'statusCode' => 400];
        }
    }

    public function read() {
        $sql = "SELECT * FROM software_engineer_applicants";
        $stmt = $this->pdo->query($sql);
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'statusCode' => 200];
    }

    public function readById($id) {
        $sql = "SELECT * FROM software_engineer_applicants WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $sql = "UPDATE software_engineer_applicants SET
                firstName = :firstName,
                lastName = :lastName,
                yearsOfExperience = :yearsOfExperience,
                skills = :skills,
                preferredCompany = :preferredCompany
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $data['id'] = $id;

        if ($stmt->execute($data)) {
            return ['message' => 'Applicant updated successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to update applicant.', 'statusCode' => 400];
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM software_engineer_applicants WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['id' => $id])) {
            return ['message' => 'Applicant deleted successfully!', 'statusCode' => 200];
        } else {
            return ['message' => 'Failed to delete applicant.', 'statusCode' => 400];
        }
    }

    public function search($query) {
        $sql = "SELECT * FROM software_engineer_applicants WHERE
                firstName LIKE :query OR
                lastName LIKE :query OR
                yearsOfExperience LIKE :query OR
                skills LIKE :query OR
                preferredCompany LIKE :query";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['query' => '%' . $query . '%']);
        return ['querySet' => $stmt->fetchAll(PDO::FETCH_ASSOC), 'statusCode' => 200];
    }
}
?>
