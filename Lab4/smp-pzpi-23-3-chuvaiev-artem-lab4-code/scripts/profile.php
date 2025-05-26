<?php
session_start();

function validateProfileData($data) {
    $errors = [];
    
    if (empty(trim($data['name']))) {
        $errors[] = "Ім'я не може бути порожнім";
    } elseif (strlen(trim($data['name'])) <= 1) {
        $errors[] = "Ім'я має містити більше одного символу";
    }
    
    if (empty(trim($data['surname']))) {
        $errors[] = "Прізвище не може бути порожнім";
    } elseif (strlen(trim($data['surname'])) <= 1) {
        $errors[] = "Прізвище має містити більше одного символу";
    }
    
    if (empty($data['dob'])) {
        $errors[] = "Дата народження обов'язкова";
    } else {
        $birthDate = new DateTime($data['dob']);
        $today = new DateTime();
        $age = $birthDate->diff($today)->y;
        
        if ($age < 16) {
            $errors[] = "Вам має бути не менше 16 років";
        }
    }
    
    if (empty(trim($data['description']))) {
        $errors[] = "Опис не може бути порожнім";
    } elseif (strlen(trim($data['description'])) < 50) {
        $errors[] = "Опис має містити не менше 50 символів";
    }
    
    return $errors;
}

$profileErrors = [];
$imageErrors = [];

if (isset($_POST['updateProfile'])) {
    $profileData = [
        'name' => $_POST['name'] ?? '',
        'surname' => $_POST['surname'] ?? '',
        'dob' => $_POST['dob'] ?? '',
        'description' => $_POST['description'] ?? ''
    ];
    
    $profileErrors = validateProfileData($profileData);
    
    if (empty($profileErrors)) {
        $profile = $_SESSION['profile'] ?? [];
        
        $profile['name'] = trim($profileData['name']);
        $profile['surname'] = trim($profileData['surname']);
        $profile['dob'] = $profileData['dob'];
        $profile['description'] = trim($profileData['description']);
        
        $_SESSION['profile'] = $profile;
        
        $_SESSION['success_message'] = "Дані профілю успішно оновлено";
        
        header("Location: ../index.php?page=profile");
        exit();
    } else {
        $_SESSION['temp_profile_data'] = $profileData;
        $_SESSION['profile_errors'] = $profileErrors;
        
        header("Location: ../index.php?page=profile");
        exit();
    }
}

if (isset($_POST['uploadImage'])) {
    if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profilePicture']['tmp_name'];
        $fileName = $_FILES['profilePicture']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = __DIR__ . '/../images/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $newFileName = uniqid('profile_', true) . '.' . $fileExtension;
            $destination = $uploadDir . $newFileName;
            
            if (move_uploaded_file($fileTmpPath, $destination)) {
                $profile = $_SESSION['profile'] ?? [];
                
                $profile['image'] = 'images/' . $newFileName;
                
                $_SESSION['profile'] = $profile;
                
                $_SESSION['success_message'] = "Зображення профілю успішно оновлено";
            } else {
                $imageErrors[] = "Помилка при завантаженні зображення";
                $_SESSION['image_errors'] = $imageErrors;
            }
        } else {
            $imageErrors[] = "Дозволені типи файлів: jpg, jpeg, png, gif";
            $_SESSION['image_errors'] = $imageErrors;
        }
    } else {
        $imageErrors[] = "Будь ласка, виберіть зображення";
        $_SESSION['image_errors'] = $imageErrors;
    }
    
    header("Location: ../index.php?page=profile");
    exit();
}
?>