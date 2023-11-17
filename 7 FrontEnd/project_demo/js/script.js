let mainValues = [];
let activeRowIndex = null;

function userFetch(url, options, callback) {
    fetch(url, options)
    .then(function(response) {
        return response.json();
    }).then(function(data) {
        if (data.error == 1) {
            throw(data.errorMsg);
        }
        
        callback(data.data)
    }).catch(function(error) {
        alert(error);
    });
}

userFetch('api/extra/read.php', null, function(data) {
    const rows = [];

    data.forEach(function(item) {
        rows.push(`<option value="${item.id}">${item.name}</option>`);
    });

    document.querySelector('#select-extra').innerHTML += rows.join('');
    updateMain();
});

function updateMain() {
    setActiveRow(null);

    userFetch('api/main/read.php', null, function(data) {
        mainValues = data;
        buildTable();
    });
}

function removeRow(index) {
    const needToRemove = confirm('Вы действительно хотите удалить запись?');

    if (!needToRemove) {
        return;
    }

    const id = mainValues[index].id;

    userFetch(`api/main/delete.php?id=${id}`, null, function() {
        updateMain();
    });
}

function buildTable() {
    const rows = [];

    mainValues.forEach(function(item, index) {
        const row = `
        <tr data-index="${index}" onclick="rowClick(${index})">
            <td>${item.name}</td>
            <td>${item.num}</td>
            <td>${item.producer}</td>
            <td>${item.extra_name}</td>
            <td onclick="event.stopPropagation(); removeRow(${index})">
                <img width="20" src="img/delete.svg">
            </td>
        </tr>`;
        rows.push(row);
    });

    document.querySelector('#main-container').innerHTML = rows.join('');
}

function setActiveRow(index) {
    if (activeRowIndex !== null) {
        const item = document.querySelector(`[data-index="${activeRowIndex}"]`);
        if (item) {
            item.classList.remove('activeRow');
        }
    }

    activeRowIndex = index;

    if (index === null) {
        ['#item-name', '#item-num', '#item-producer','#select-extra'].forEach(function(id) {
            document.querySelector(id).value = null;
        });

        return;
    }

    const item = document.querySelector(`[data-index="${index}"]`);
    if (item) {
        item.classList.add('activeRow');
    }
}

function rowClick(index) {
    setActiveRow(index);
    const item = mainValues[index];

    document.querySelector('#item-name').value = item.name;
    document.querySelector('#item-num').value = item.num;
    document.querySelector('#item-producer').value = item.producer;
    document.querySelector('#select-extra').value = item.extra_id;
}

function addRow() {
    const bodyJson = {
        name: document.querySelector('#item-name').value,
        num: document.querySelector('#item-num').value,
        producer: document.querySelector('#item-producer').value,
        extra_id: document.querySelector('#select-extra').value
    }

    userFetch(`api/main/upgrade.php`, {
        method: 'POST',
        body: JSON.stringify(bodyJson)
    }, function(data) {
        updateMain();
    });
}

function editRow() {
    if (activeRowIndex === null) {
        return;
    }

    const bodyJson = {
        id: mainValues[activeRowIndex].id,
        name: document.querySelector('#item-name').value,
        num: document.querySelector('#item-num').value,
        producer: document.querySelector('#item-producer').value,
        extra_id: document.querySelector('#select-extra').value
    }

    userFetch(`api/main/upgrade.php`, {
        method: 'POST',
        body: JSON.stringify(bodyJson)
    }, function() {
        updateMain();
    });
}