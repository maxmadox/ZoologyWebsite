<?php
session_start();

include 'database/database.php';
include 'header.php';
?>  

<main class="courses-page-view">
    <div class="courses-content">
        <h1 class="courses-title">Courses</h1>

        <?php
        $bscCourses = $conn->query("SELECT * FROM bsc_courses ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);
        $mscCourses = $conn->query("SELECT * FROM msc_courses ORDER BY id ASC")->fetch_all(MYSQLI_ASSOC);

        $bscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='bsc'")->fetch_assoc()['marks_info'] ?? '';
        $mscMarks = $conn->query("SELECT marks_info FROM internal_marks WHERE course_type='msc'")->fetch_assoc()['marks_info'] ?? '';
        ?>

        <div class="course-visible-table">
            <div class="courses-table-heading">
                <div class="course-table-title">
                    <h2>B.Sc Courses</h2>
                </div>
                <?php if($bscMarks): ?>
                    <span class="internal-marks">Internal Marks: <?php echo htmlspecialchars($bscMarks); ?></span>
                <?php endif; ?>
            </div>           
        
            <table>
                <thead>
                    <tr>
                        <th>CLASS</th>
                        <th>PAPER TITLE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bscCourses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['class']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($course['papers'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="course-visible-table">
            <div class="courses-table-heading">
                <div class="course-table-title">
                    <h2>M.Sc Courses</h2>
                </div>
                <?php if($mscMarks): ?>
                    <span class="internal-marks">Internal Marks: <?php echo htmlspecialchars($mscMarks); ?></span>
                <?php endif; ?>
            </div>   
        
            <table>
                <thead>
                    <tr>
                        <th>CLASS</th>
                        <th>PAPER TITLE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($mscCourses as $course): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($course['class']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($course['papers'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>
