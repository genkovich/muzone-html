import axios from "axios";

const createServiceForm = document.querySelector("#create-service");

createServiceForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    let isValid = true;

    const title = formData.get("title");
    if (!title || title.length < 3 || title.length > 255) {
        this.querySelector("[name=title]").classList.add("is-invalid");
        isValid = false;
    }

    const direction = formData.get("direction");
    if (!direction || direction.length < 3 || direction.length > 255) {
        this.querySelector("[name=direction]").classList.add("is-invalid");
        isValid = false;
    }

    const age = formData.get("age");
    if (!age || age.length < 3 || age.length > 255) {
        this.querySelector("[name=age]").classList.add("is-invalid");
        isValid = false;
    }

    const price = formData.get("price");
    if (!price || price < 1) {
        this.querySelector("[name=price]").classList.add("is-invalid");
        isValid = false;
    }

    const lessons = formData.get("lessons");
    if (!lessons || lessons < 1) {
        this.querySelector("[name=lessons]").classList.add("is-invalid");
        isValid = false;
    }

    if (!isValid) {
        return;
    }

    const url = this.dataset.url;
    axios.post(url, formData)
        .then(function (response) {
            console.log(response)
        }).catch(function (error) {
        console.log(error)
    });
});

createServiceForm.addEventListener("click", function (e) {
    if (e.target.tagName !== "INPUT") {
        return;
    }

    if (e.target.classList.contains("is-invalid")) {
        e.target.classList.remove("is-invalid");
    }
});

const serviceList = document.querySelector(".services__table");

serviceList.addEventListener("click", function (e) {
    const target = e.target.closest(".services-item");

    if (!target) {
        return;
    }

    location.href = target.dataset.serviceUrl;

}, false);

