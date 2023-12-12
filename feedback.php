<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phản hồi về website</title>
  <style>
  /* FEEDBACK */

  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }

  h2 {
      text-align: center;
  }

  label {
      color: #333333;
  }

  span {
      color:#333333;
  }

  .feedback-form {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }

  .bold-text {
    color: #333333;
    font-weight: 600;
  }

  .rating-container {
    margin-bottom: 30px;
  }

  .rating-container span {
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s; /* Hiệu ứng chuyển màu trong 0.2 giây */
  }

  .rating-container span:hover,
  .rating-container span.active {
    color: #ffd700; /* Màu vàng của ngôi sao */
  }

  .rounded-border:hover {
      border: 2px solid rgb(98, 189, 219);
  }

  .comment-input,
  .contact-input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-family: Arial;
  }

  .comment-input:focus,
  .contact-input:focus {
      border-color: #66afe9;
      outline: 0;
      -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
              box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
  }

  .submit-btn {
    display: block;
    margin: 0 auto;
    margin-top: 15px;
    margin-bottom: 10px;
    text-align: center;
    background-color: #4caf50;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
  }

  .submit-btn:hover {
    background-color: #45a049; /* Màu xanh đậm hơn khi di chuột vào */
  }
  </style>

</head>
<body>
  <div class="feedback-form">
    <h2>Phản hồi về website</h2>
    <div class="rating-container">
      <label class="bold-text">Đánh giá sao:</label>
      <span onclick="rateStar(1)" id="star1" class="star">&#9733;</span>
      <span onclick="rateStar(2)" id="star2" class="star">&#9733;</span>
      <span onclick="rateStar(3)" id="star3" class="star">&#9733;</span>
      <span onclick="rateStar(4)" id="star4" class="star">&#9733;</span>
      <span onclick="rateStar(5)" id="star5" class="star">&#9733;</span>
    </div>
    <label class="bold-text">Ý kiến phản hồi:</label><br></br>
    <textarea class="comment-input rounded-border" rows="4" placeholder="Nhập ý kiến của bạn"></textarea>
    <label class="bold-text">Thông tin liên hệ:</label><br></br>
    <input type="name" class="contact-input rounded-border" placeholder="Họ và tên">
    <input type="email" class="contact-input rounded-border" placeholder="Email">
    <input type="tel" class="contact-input rounded-border" placeholder="Số điện thoại">
    <button class="submit-btn" onclick="submitForm()">Gửi phản hồi</button>
  </div>

<script>
class FeedbackForm {
  constructor() {
    this.selectedRating = 0;
    this.stars = document.querySelectorAll('.star');
    this.commentInput = document.querySelector('.comment-input');
    this.contactInputs = document.querySelectorAll('.contact-input');
    this.emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    this.phoneRegex = /^(0[0-9]{9})$/;
    this.init();
  }

  init() {
    this.stars.forEach((star, index) => {
      star.addEventListener('click', () => this.rateStar(index + 1));
    });

    document.querySelector('.submit-btn').addEventListener('click', () => this.submitForm());
  }

  rateStar(star) {
    this.selectedRating = star;
    this.stars.forEach((starElement, index) => {
      starElement.classList.remove('active');
      if (index < this.selectedRating) {
        starElement.classList.add('active');
      }
    });
  }

  submitForm() {
    const comment = this.commentInput.value;
    const contactName = this.contactInputs[0].value;
    const contactEmail = this.contactInputs[1].value;
    const contactPhone = this.contactInputs[2].value;

    if (
      this.selectedRating === 0 ||
      comment === '' ||
      contactName === '' ||
      !this.emailRegex.test(contactEmail) ||
      !this.phoneRegex.test(contactPhone)
    ) {
      alert('Vui lòng nhập thông tin hợp lệ!');
    } else {
      console.log('Đánh giá sao:', this.selectedRating);
      console.log('Ý kiến phản hồi:', comment);
      console.log('Họ và tên:', contactName);
      console.log('Email:', contactEmail);
      console.log('Số điện thoại:', contactPhone);
      alert('Cảm ơn đã gửi phản hồi!');
      this.resetForm();
    }
  }

  resetForm() {
    this.selectedRating = 0;
    this.stars.forEach((star) => star.classList.remove('active'));
    this.contactInputs.forEach((input) => (input.value = ''));
    this.commentInput.value = '';
  }
}

// Khởi tạo đối tượng
const feedback = new FeedbackForm();
</script>

</body>
</html>