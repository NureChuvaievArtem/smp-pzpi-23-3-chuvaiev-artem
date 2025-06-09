<?php
$profileErrors = $_SESSION['profile_errors'] ?? [];
$imageErrors = $_SESSION['image_errors'] ?? [];
$successMessage = $_SESSION['success_message'] ?? '';

unset($_SESSION['profile_errors']);
unset($_SESSION['image_errors']);
unset($_SESSION['success_message']);

$profile = $_SESSION['profile'] ?? [];

$tempProfileData = $_SESSION['temp_profile_data'] ?? [];
unset($_SESSION['temp_profile_data']);

$name = isset($tempProfileData['name']) ? $tempProfileData['name'] : ($profile['name'] ?? '');
$surname = isset($tempProfileData['surname']) ? $tempProfileData['surname'] : ($profile['surname'] ?? '');
$dob = isset($tempProfileData['dob']) ? $tempProfileData['dob'] : ($profile['dob'] ?? '');
$description = isset($tempProfileData['description']) ? $tempProfileData['description'] : ($profile['description'] ?? '');
$image = $profile['image'] ?? null;
?>

<link rel="stylesheet" href="./styles/profile.css">

<div class="profile-container">
    <h1>User Profile</h1>
    
    <?php if ($successMessage): ?>
        <div class="success-message"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    
    <div class="profile-forms">
        <div class="image-form-container">
            <h2>Profile Picture</h2>
            
            <?php if (!empty($imageErrors)): ?>
                <div class="error-messages">
                    <?php foreach ($imageErrors as $error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="./scripts/profile.php" method="POST" enctype="multipart/form-data" class="image-form">
                <div class="image-preview">
                    <?php if ($image): ?>
                        <img src="<?= htmlspecialchars($image) ?>" alt="Profile Picture">
                    <?php else: ?>
                        <div class="placeholder">No Image</div>
                    <?php endif; ?>
                </div>
                <div class="file-input-container">
                    <input type="file" id="profilePicture" name="profilePicture" accept="image/jpeg,image/png,image/gif">
                    <button type="submit" name="uploadImage">Upload Image</button>
                </div>
            </form>
        </div>
        
        <div class="profile-form-container">
            <h2>Personal Information</h2>
            
            <?php if (!empty($profileErrors)): ?>
                <div class="error-messages">
                    <?php foreach ($profileErrors as $error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <form action="./scripts/profile.php" method="POST" class="profile-form">
                <div class="row">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="surname">Surname:</label>
                        <input type="text" id="surname" name="surname" value="<?= htmlspecialchars($surname) ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?= htmlspecialchars($dob) ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Brief Description (min 50 characters):</label>
                    <textarea id="description" name="description" rows="7"><?= htmlspecialchars($description) ?></textarea>
                </div>
                
                <div class="buttons">
                    <button type="submit" name="updateProfile">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>