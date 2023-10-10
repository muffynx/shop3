<?php
include 'config.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="styles.css" />

<style>
.banner-container {
  width: 40%;
  max-width: 1500px; /* adjust max-width as needed */
  height: 250px;
  overflow: hidden;
  position: relative;
  margin-bottom: 25px;
  border: 2px solid #000;
}

.slider {
  width: 400%; /* adjust width based on number of images */
  height: 100%;
  position: relative;
  left: 0;
  transition: left 0.5s ease-in-out;
}

.slider img {
  width: 25%; /* adjust width based on number of images */
  height: 100%;
  float: left;
}

.slider-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  z-index: 1;
}

.slider-nav button {
  border-radius: 20px;
  border: none;
  color: #000;
  font-size: 24px;
  padding: 10px;
  cursor: pointer;
  outline: none;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}

.slider-nav .prev {
  left: 0;
  transform: translateY(6px);
}

.slider-nav .next {
  transform: translateX(480px);
  margin-bottom: 60%;
  display: flex;
}

</style>

  <div class="container mt-5">


  <div class="catgory">
    <a href="add_product.php" class="btn btn-primary mb-3">HOME</a>
    <a href="category/kk.php" class="btn  mb-3" style="padding: 6px 15px; border: 2px solid #000;">kk</a>
    <a href="category/nn.php" class="btn  mb-3" style="padding: 6px 15px; border: 2px solid #000;">nn</a>
    <a href="category/ii.php" class="btn  mb-3" style="padding: 6px 15px; border: 2px solid #000;">ii</a>
    <a href="category/vv.php" class="btn  mb-3" style="padding: 6px 15px; border: 2px solid #000;">vv</a>
    </div>
    <!-- BANNER -->

    <div class="bannerbox" style="display: flex;">

    <div class="banner-container">
  <div class="slider">
    <img src="https://huahinpocketguide.com/wp-content/uploads/2019/01/baanSM_cover_00.jpg">
    <img src="https://huahinpocketguide.com/wp-content/uploads/2019/01/baanSM_cover_00.jpgv">
    <img src="https://huahinpocketguide.com/wp-content/uploads/2019/01/baanSM_cover_00.jpg">
  </div>
  <div class="slider-nav">
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
  </div>
</div>

<div class="text-hot" style="max-width: 60%; padding: 30px; border: 1px solid #000; max-height: 250px;">
  <h2>Hot Sale<i class="fa-brands fa-hotjar" style="margin-left: 1rem; color: #FF7000;"></i></h2>
  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem nihil nam consequatur expedita laboriosam. Amet ducimus sequi libero labore modi?</p>
  <a href="#" style="text-decoration: none; padding: 7px 16px; border: 1px solid #000; text-transform: uppercase ; color: #000;">Shop Now</a>
</div>


    </div>



<script>
  const slider = document.querySelector('.slider');
const prevBtn = document.querySelector('.prev');
const nextBtn = document.querySelector('.next');
const slideWidth = slider.clientWidth / 4; /* adjust slideWidth based on number of images */
let slideIndex = 0;

prevBtn.addEventListener('click', () => {
  slideIndex--;
  if (slideIndex < 0) {
    slideIndex = 3; /* adjust slideIndex based on number of images */
  }
  slider.style.left = -slideIndex * slideWidth + 'px';
});

nextBtn.addEventListener('click', () => {
  slideIndex++;
  if (slideIndex > 3) { /* adjust slideIndex based on number of images */
    slideIndex = 0;
  }
  slider.style.left = -slideIndex * slideWidth + 'px';
});

</script>


<script>
  const slider2 = document.querySelector('.slider2');
const prevBtn2 = document.querySelector('.prev2');
const nextBtn2 = document.querySelector('.next2');
const slideWidth2 = slider2.clientWidth / 4; /* adjust slideWidth based on number of images */
let slideIndex2 = 0;

prevBtn2.addEventListener('click', () => {
  slideIndex2--;
  if (slideIndex2 < 0) {
    slideIndex2 = 3; /* adjust slideIndex based on number of images */
  }
  slider2.style.left = -slideIndex2 * slideWidth2 + 'px';
});

nextBtn2.addEventListener('click', () => {
  slideIndex2++;
  if (slideIndex2 > 3) { /* adjust slideIndex based on number of images */
    slideIndex2 = 0;
  }
  slider2.style.left = -slideIndex2 * slideWidth2 + 'px';
});

</script>

<!-- BANNER -->


    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="col">
          <div class="card h-100" style="border: 2px solid black; position: relative;">
          <h6 style="position: absolute; left: 85%;  top:3px; padding: 2px 7px; background-color: #FFBF00;">Sale</h6>
          <div class="align-middle" style="display: flex; align-items: center; justify-content: center;">
          <img src="<?= $row['image']; ?>" class="card-img-top w-75" alt="<?= $row['name']; ?>" style="max-height: 250px; object-fit: cover;">

          </div>
            <div class="card-body" style="display: flex; justify-content: space-between;">
              <h5 class="card-title"><?= $row['name']; ?></h5>
              <p class="card-text"><?= number_format($row['price'], 2); ?> <strong>THB</strong></p>
            </div>
            <div class="card-footer" style="display: flex; justify-content: space-between;">
              <a href="login.php" style="text-decoration: none; color: #000; padding: 5px 13px; border: 2px solid #000;">Add Cart</a>
              <a href="#">Description</a>
              <!-- <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-warning">Edit</a> -->
              <!-- <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a> -->
            </div>
          </div>
        </div>
         <!-- Add the Modal code here -->
         <div class="modal fade" id="productModal-<?= $row['id']; ?>" tabindex="-1" aria-labelledby="productModalLabel-<?= $row['id']; ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="productModalLabel-<?= $row['id']; ?>"><?= $row['name']; ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: #000;"></button>
                </div>
                <div class="modal-body" style="display: flex; justify-content: space-between; padding: 5px 30px;">
                  <img src="<?= $row['image']; ?>" class="img-fluid mb-3" alt="<?= $row['name']; ?>" style="width: 200px;">
                  <div class="pbox" style="width: 60%; border: 1px solid #000; align-items: center; display: flex; text-align: center; justify-content: center;" >
                  <p style=" align-items: center; justify-content: center;"><?= $row['description']; ?></p>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Modal code -->
      <?php endwhile; ?>
    </div>


  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>
