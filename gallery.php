<?php 
session_start();
include 'database/database.php';
include 'header.php';

$result = mysqli_query($conn, "SELECT * FROM gallery ORDER BY date DESC");


$horizontalImages = [];
$verticalImages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $imagePath = $row['image_path'];
    if (file_exists($imagePath)) {
        $size = getimagesize($imagePath);
        $width = $size[0];
        $height = $size[1];
        $orientation = ($width > $height) ? 'horizontal' : 'vertical';
    } else {
        $orientation = 'horizontal'; 
    }

    if ($orientation === 'horizontal') {
        $horizontalImages[] = $row;
    } else {
        $verticalImages[] = $row;
    }
}
?>

<main class="gallery-container">
    <h1 class="gallery-title">Gallery</h1>

    <div class="gallery-section">
        <?php 
        
        for ($i = 0; $i < count($horizontalImages); $i += 2): ?>
            <div class="gallery-row horizontal-row">
                <?php for ($j = $i; $j < $i + 2 && $j < count($horizontalImages); $j++): ?>
                    <div class="gallery-item horizontal">
                        <img src="<?php echo htmlspecialchars($horizontalImages[$j]['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($horizontalImages[$j]['title']); ?>">
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>

        <?php 
        
        for ($i = 0; $i < count($verticalImages); $i += 2): ?>
            <div class="gallery-row vertical-row">
                <?php for ($j = $i; $j < $i + 2 && $j < count($verticalImages); $j++): ?>
                    <div class="gallery-item vertical">
                        <img src="<?php echo htmlspecialchars($verticalImages[$j]['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($verticalImages[$j]['title']); ?>">
                    </div>
                <?php endfor; ?>
            </div>
        <?php endfor; ?>
    </div>
</main>

<?php include 'footerdisplay.php'; ?>
