<!-- templates/page.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $pageTitle ?? 'Page'; ?></title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
</head>
<body>
  <div class="container">

    <!-- Sidebar Include -->
    <?php include 'includes/sidebar.php'; ?>

    <!-- Header Include -->
    <?php include 'includes/header.php'; ?>

    <!-- Dynamic Page Content -->
    <main class="main-content">
      <?php include $contentPage; ?>
    </main>

  </div>
</body>
</html>
