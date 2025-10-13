 <?php
  include $this->resolve("partials/_header.php");
  ?>

 <h1> <?php echo e($dangerousData) ?></h1>
 <?php
  include $this->resolve("partials/_footer.php")
  ?>