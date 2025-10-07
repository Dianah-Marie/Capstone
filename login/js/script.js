document.addEventListener("DOMContentLoaded", function () {
  const loginForm = document.getElementById("loginForm");
  const forgetForm = document.getElementById("forgetForm");
  const logoWrapper = document.getElementById("logoWrapper");

  document.getElementById("toForget").addEventListener("click", function (e) {
    e.preventDefault();
    loginForm.classList.remove("show");
    forgetForm.classList.add("show");
    logoWrapper.classList.add("right"); // move logo to right
  });

  document.getElementById("showLogin").addEventListener("click", function (e) {
    e.preventDefault();
    forgetForm.classList.remove("show");
    loginForm.classList.add("show");
    logoWrapper.classList.remove("right"); // move logo back to left
  });
});

 