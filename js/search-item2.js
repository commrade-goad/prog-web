let buy_array = [];
let uang = 0;
let available_qty = {};

function cunny() {
    let table_data = [];
    let query = document.getElementById("sitem").value;
    let content = `
        <table class='table table-dark table-striped'>
        <thead>
        <tr>
        <th></th>
        <th>kodeitem</th>
        <th>Nama</th>
        <th>harga</th>
        <th>qty</th>
        <th>satuan</th>
        </tr>
        </thead>
        <tbody>
    `;
    $.ajax({
        url: '/php-component/search-item.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            for (let index = 0; index < data.data.length; index++) {
                const kodeitem = data.data[index].kodeitem;
                const nama = data.data[index].nama;
                const hargabeli = data.data[index].hargabeli;
                const stok = data.data[index].stok;
                const satuan = data.data[index].satuan;

                // Initialize available_qty if not already set
                if (!available_qty[kodeitem]) {
                    available_qty[kodeitem] = stok;
                }

                table_data.push(data.data[index]);
                content += `
                    <tr>
                    <td> <button id='add-${kodeitem}' class='table-button p-1'><i class='nf nf-fa-plus'></i></button></td>
                    <td> ${kodeitem} </td>
                    <td> ${nama} </td>
                    <td> ${hargabeli} </td>
                    <td> <input type='number' id='buy-qty-${kodeitem}' min='1' value='1' style='background: rgb(33, 37, 41); border: none; color: white; width: 70px;'></td>
                    <td> ${satuan} </td>
                    </tr>
                    `;
            }
            content += `</tbody>`;
            content += `</table>`;
            $('#table-me').html(content);

            for (let index = 0; index < table_data.length; index++) {
                const current_data = table_data[index];
                let element = document.getElementById(`add-${current_data.kodeitem}`);
                if (element != null) {
                    element.addEventListener("click", function() {
                        let qtyInput = document.getElementById(`buy-qty-${current_data.kodeitem}`);
                        if (qtyInput != null) {
                            let qty = parseInt(qtyInput.value);

                            if (available_qty[current_data.kodeitem] - qty <= 0) {
                                document.getElementById(`add-${current_data.kodeitem}`).disabled = true;
                            } else {
                                document.getElementById(`add-${current_data.kodeitem}`).disabled = false;
                            }

                            // Check if item already exists in buy_array
                            let existingItem = buy_array.find(item => item.kodeitem === current_data.kodeitem);

                            if (existingItem) {
                                // Update the quantity of the existing item
                                existingItem.qty = parseInt(existingItem.qty) + qty;
                            } else {
                                // Add new item to buy_array
                                current_data.qty = qty;
                                buy_array.push(current_data);
                            }

                            // Update available_qty
                            available_qty[current_data.kodeitem] -= qty;
                            updateAvailableQty();

                            // Refresh the cart display
                            ayonuelnigg(buy_array);
                            handleSumbit(buy_array);
                        }
                    });
                }
            }
        },
        data: {
            q: query.replace(/(\r\n|\n|\r)/gm, " "),
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' - ' + error);
        }
    });
}

function updateAvailableQty() {
    for (const kodeitem in available_qty) {
        let inputElement = document.getElementById(`buy-qty-${kodeitem}`);
        if (inputElement) {
            inputElement.max = available_qty[kodeitem];
            let maxLabel = inputElement.nextSibling;
            if (maxLabel) {
                maxLabel.nodeValue = ` / ${available_qty[kodeitem]}`;
            }
        }
    }
}

function handleSumbit(data) {
    if (data.length >= 1) {
       document.getElementById("checkout-me").disabled = false; 
    } else {
       document.getElementById("checkout-me").disabled = true; 
    }
    if (uang < 0) {
       document.getElementById("checkout-me").disabled = true; 
    }
}

function ayonuelnigg(data) {
    const co = document.getElementById('co');
    if (data.length <= 0 || data == null) {
        co.innerHTML = `<h4>Tidak ada data.</h4>`;
    } else {
        let builded = `
        <table class='table table-dark table-striped'>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>qty</th>
                    <th>harga</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        `;
        let sum = 0;
        for (let index = 0; index < data.length; index++) {
            const element = data[index];
            builded += `<tr>
            <td>${element.nama}</td>
            <td>${element.qty}</td>
            <td>${element.hargabeli}</td>
            <td> <button id='rm-${element.kodeitem}' class='table-button p-1 delete-btn' data-index='${index}'><i class='nf nf-fa-trash'></i></button></td>
            </tr>`;
            sum += element.qty * element.hargabeli;
        }
        builded += `<tr>
        <td></td>
        <td class='fw-bold'>Total</td>
        <td class='fw-bold'>${sum}</td>
        <td></td>
        </tr>`;
        const saldo = document.getElementById("rekening");
        saldo.addEventListener("change", function() {
            ayonuelnigg(buy_array);
        });
        const selectedOption = saldo.options[saldo.selectedIndex];
        const uangValue = selectedOption.getAttribute('uang');
        uang = uangValue - sum;
        if (uang < 0) {
            builded += `<tr>
            <td></td>
            <td class='fw-bold text-danger'>Melebihi saldo rekening sebanyak </td>
            <td class='fw-bold text-danger'>${(uangValue - sum) * -1}</td>
            <td></td>
            </tr>`;
        }
        builded += `</tbody></table>`;
        co.innerHTML = builded;

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');
                const id = this.getAttribute('id');
                const id_only = id.slice(3, id.length);
                deleteItem(index);
                document.getElementById(`add-${id_only}`).disabled = false;
                handleSumbit(buy_array);
            });
        });
    }
}

function alterdb(data_arr) {
        $.ajax({
        url: '/php-component/add-pembelian.php',
        type: 'GET',
        dataType: 'json',
        success: function() {
            window.alert("Data Berhasil di tambahkan!");
            window.location = "/dashboard/";
        },
        data: {
            q: data_arr,
            no: document.getElementById('nonota').innerText,
            rek: document.getElementById('rekening').value,
            sup: document.getElementById('pemasok').value,
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error: ' + status + ' - ' + error);
        }
    });
}

function deleteItem(index) {
    const item = buy_array[index];
    available_qty[item.kodeitem] += parseInt(item.qty);
    buy_array.splice(index, 1);
    updateAvailableQty();
    ayonuelnigg(buy_array);
}

cunny();
ayonuelnigg(buy_array);

$(document).ready(function () {
    $('#sitem').on('input', function () {
        cunny();
    });
});

$(document).ready(function() {
    $('#checkout-me').on('click', function(){
        alterdb(buy_array);
    });
});

