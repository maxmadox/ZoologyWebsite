<?php include 'header.php'; ?>

<?php
// Fetch teachers
$teachersResult = mysqli_query($conn, "SELECT * FROM teachers ORDER BY full_name ASC");

// Fetch gallery
$galleryResult = mysqli_query($conn, "SELECT * FROM gallery ORDER BY date DESC");


$noticeresult = mysqli_query($conn, "SELECT * FROM notices ORDER BY date DESC LIMIT 5");

$horizontalImages = [];

while ($row = mysqli_fetch_assoc($galleryResult)) {
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
    }
}
?>

<main>
        <div id="snake-container">
                <?php include 'snake.php'; ?>
        </div>
       <section class="home-intro">
        <div class="intro-wrapper">
            <div class="intro-text">
                <h1>Department of Zoology</h1>
                <p>
                    Welcome to Kirodimal Govt. Arts & Science College. <br>
                    Explore our Zoology department and hands-on learning approach.
                </p>
                
            </div>

            <div class="intro-image">
                <img src="content/gecko.jpg" alt="gecko">
            </div>
        </div>
    </section>

    <section class="gallerynotice">
    
    <div class="index-gallery-container">
    <div class="index-gallery-slider">
        <?php foreach ($horizontalImages as $img): ?>
            <div class="index-gallery-slide">
                <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['title']); ?>">
                <div class="gallery-hover-title"><?php echo htmlspecialchars($img['title']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    </div>


            <div class="notice-page-view">
                <div class="notice-table-content">
                <h1 class="notice-title">Notices</h1>

                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($noticeresult)): ?>
                                <tr>
                                    <td><?php echo date('d-m-Y', strtotime($row['date'])); ?></td>
                                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td class="actions-cell">
                                        <a href="<?php echo $row['file_path']; ?>" target="_blank" class="edit">View</a>
                                        <a href="<?php echo $row['file_path']; ?>" download class="edit">Download</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
    </section>

    


    <section class="principal-section">
    <div class="principal-wrapper">
        <div class="principal-image">
            <img src="content/principal.jpeg" alt="Principal">
        </div>
        <div class="principal-text">
            <h1>From the Principal's Desk</h1>
            <p>
                It gives me great pride to share that Kirodimal Govt. College Raigarh continues to grow as a strong centre of higher education in the tribal belt of Chhattisgarh. Since 1958, the college has focused on discipline, learning and student development, and we remain committed to providing the right opportunities and facilities across Arts, Commerce and Science to shape confident and capable learners.
            </p>

            <p>
                The Department of Zoology carries this spirit forward with dedication and curiosity. Through active learning, practical exposure and supportive teaching, the department encourages students to explore the scientific world with interest and responsibility. I believe that with continuous effort from faculty and students, the department will keep achieving new heights and building a bright academic environment.
            </p>


            <strong>Dr. Manorama Pandey<br>
            Principal</strong>
        </div>
    </div>
    </section>



    <section class="intro-faculty-container">
        <h1 class="intro-faculty-title">Faculty</h1>

        <div class="intro-faculty-list">
            <?php
            $i = 0;
            while($teacher = mysqli_fetch_assoc($teachersResult)):
                $quals = explode(', ', $teacher['qualification'] ?? '');
                $quals_display = implode(', ', $quals);
                $experience = date('Y') - date('Y', strtotime($teacher['date_joined']));
            ?>
            <div class="intro-faculty-item <?php echo $i % 2 == 0 ? 'image-left' : 'image-right'; ?>">
                <div class="intro-faculty-image">
                    <?php if(!empty($teacher['image_path'])): ?>
                        <img src="<?php echo $teacher['image_path']; ?>" alt="<?php echo $teacher['full_name']; ?>">
                    <?php else: ?>
                        <img src="content/default.png" alt="Default Image">
                    <?php endif; ?>
                </div>
                <div class="intro-faculty-info">
                    <h2><?php echo $teacher['full_name']; ?></h2>
                    <p class="qualification"><?php echo $quals_display; ?></p>
                    <p class="inspiring">Inspiring students since<br><?php echo $experience; ?> years.</p>
                </div>
            </div>
            <?php $i++; endwhile; ?>
        </div>
    </section>



</main>

<?php include 'footerdisplay.php'; ?>



