let btnAuditorium = document.getElementById("button_auditorium");
let btnGroup = document.getElementById("button_group");
let btnTeacher = document.getElementById("button_teacher_name");

let selectAuditorium = document.getElementById("select_auditorium");
let selectGroup = document.getElementById("select_group");
let selectTeacher = document.getElementById("select_teacher_name");

let placeAuditorium = document.getElementById("auditorium");
let placeGroup = document.getElementById("group");
let placeTeacher = document.getElementById("teacher_name");

btnAuditorium.addEventListener("click", () => {
    let xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        `./selecting_audience.php?name_auditorium=${selectAuditorium.value}`,
        true
    );
    xhr.responseType = "text";
    xhr.send();
    xhr.onload = () => {
        placeAuditorium.innerHTML = xhr.response;
    };
    xhr.onerror = () => {
        alert("Error");
    };
});

btnGroup.addEventListener("click", () => {

    fetch(`./selecting_group.php?name_group=${selectGroup.value}`)
        .then((response) => {
            return response.json();
        })
        .then((data) => {

            placeGroup.innerHTML = "";
            let table = document.createElement("table");
            for (let rows of data) {
                let row = document.createElement("tr");
                for (let key in rows) {
                    let data = document.createElement("td");
                    data.innerText = rows[key];
                    row.appendChild(data);
                }
                table.appendChild(row);
            }
            table.setAttribute(
                "style",
                "text-align: center; border: 1px solid black; border-collapse: collapse; margin: auto; width: 100%"
            );
            placeGroup.appendChild(table);

        })
        .catch((err) => {
            alert(err)
        })
});

btnTeacher.addEventListener("click", () => {
    let xhr = new XMLHttpRequest();
    xhr.open(
        "GET",
        `./selecting_teacher.php?teacher_name=${selectTeacher.value}`,
        true
    );
    xhr.send();
    xhr.onload = () => {
        placeTeacher.innerHTML = "";
        let response = xhr.responseXML.getElementsByTagName("lessons");
        let table = document.createElement("table");
        for (let i of response) {
            let rows = i.children;
            for (let j of rows) {
                let data = j.children;
                let tr = document.createElement("tr");
                for (let k of data) {
                    let td = document.createElement("td");
                    td.innerHTML = k.innerHTML;
                    tr.appendChild(td);
                }
                table.appendChild(tr);
            }
        }
        table.setAttribute(
            "style",
            "text-align: center; border: 1px solid black; border-collapse: collapse; margin: auto; width: 100%"
        );
        placeTeacher.appendChild(table);
    };
    xhr.onerror = () => {
        alert("Error");
    };
});
