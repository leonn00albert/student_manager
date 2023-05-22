function renderTable(item) {

    return (
        `               <td><img src=${item.avatar} class="avatar" ></td>
                         <td><span class="fi fi-${item.country.toLowerCase()} fi"></span></td>    
                        <td>${item.id}</td> 
                        <td>${item.name}</td>
                        <td>${item.grade}</td>
                        <td><a href="/classroom/${item.class}" >${item.class} </a></td>
                        <td>
                            <a href="/students/edit/${item.id}" class="btn btn-info btn-sm "><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                            <button onclick="handleDeleteById('${item.id}')" type="button" class="btn btn-danger btn-sm mx-2"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            <a href="/students/${item.id}" class="btn btn-secondary btn-sm "><i class="fa fa-eye" aria-hidden="true"></i> </a>
                            </td>
                
                `
    )
}
window.onload = function () {
    let path = window.location.href.split("?")[1];
    if(path === undefined) {
        path = 'page=1';
    }
    fetch('/api/students?' + path)
        .then(response => response.json())
        .then(res => {
            const dataList = document.getElementById('studentsTable');
            if (res.alerts.alert) {
                const cardBody = document.getElementById('cardBody');
                let html = `
                    <div class="alert alert-dismissible alert-${res.alerts.alert.type}">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <h4 class="alert-heading">${res.alerts.alert.type.toUpperCase()}!</h4>
                    <p class="mb-0">${res.alerts.alert.message}</p>
                    </div>
                `
                cardBody.insertAdjacentHTML('afterbegin', html);

            }
            console.log(res.current_page);
            handlePagination(res.total_pages, res.current_page);
            document.getElementById("studentCount").innerHTML = res.total_records;
            res.data.reverse().forEach(item => {
                console.log(item)
                const listItem = document.createElement('tr');
                listItem.innerHTML = renderTable(item);
                dataList.appendChild(listItem);
            });
        })
        .catch(error => console.error(error));

};

function handleDeleteById(id) {

    fetch('/api/students/' + id, {
        method: 'DELETE',

    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            window.location = '/';
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
};

let lastClickedSortMethod = "";
function handleSort(method) {
    let path = window.location.href.split("?")[1];

    if(path === undefined) {
        path = 'page=1';
    }

    let desc = lastClickedSortMethod === method;
    if (desc === true) {
        lastClickedSortMethod = "";
    } else {
        lastClickedSortMethod = method;
    }

    fetch('/api/students?sortby=' + method + '&desc=' + desc + "&" + path)
        .then(response => response.json())
        .then(res => {
            const dataList = document.getElementById('studentsTable');
            dataList.innerHTML = "";

            if (res.alerts.alert) {
                const cardBody = document.getElementById('cardBody');
                let html = `
                    <div class="alert alert-dismissible alert-${res.alerts.alert.type}">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <h4 class="alert-heading">${res.alerts.alert.type.toUpperCase()}!</h4>
                    <p class="mb-0">${res.alerts.alert.message}</p>
                    </div>
                `
                cardBody.insertAdjacentHTML('afterbegin', html);

            }
            if (desc === true) {
                res.data = res.data.reverse();
            }
            res.data.forEach(item => {
                const listItem = document.createElement('tr');
                listItem.innerHTML = renderTable(item);
                dataList.appendChild(listItem);
            });
        })
        .catch(error => console.error(error));

};

function handleSeedData() {
    let count = document.getElementById("seedData").value;
    fetch('/api/seed?count=' + count)
        .then(response => response.json())
        .then(res => {
            window.location = '/';
        })
        .catch(error => console.error(error));
}

function handleDeleteData() {
    fetch('/api/delete')
        .then(response => response.json())
        .then(res => {
            window.location = '/';
        })
        .catch(error => console.error(error));
}

function handlePagination(pages, current) {
    let back = parseInt(current) - 1 > 0 ? parseInt(current) - 1 : 1;
    let forward = parseInt(current) + 1 < pages ? parseInt(current) + 1 : pages;
    let html = `
    <li class="page-item">
      <a class="page-link" href="/?page=${back}">&laquo;</a>
    </li>
    `;
    let pagination = document.getElementById("pagination");
    for (let i = 1; i <= pages; i++) {
        if (i == current) {
            html += `
        <li class="page-item active">
                <a class="page-link" href="/?page=${i}">${i}</a>
              </li>
        `
        } else {
            html += `
        <li class="page-item ">
                <a class="page-link" href="/?page=${i}">${i}</a>
              </li>
        `
        }

    }

    html += `

    <li class="page-item">
         <a class="page-link" href="/?page=${forward}">&raquo;</a>
     </li>
    `
    pagination.innerHTML = html;
}
