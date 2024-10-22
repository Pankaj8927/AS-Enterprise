<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <input type="text" id="amountUpdate" data-id="25" placeholder="Enter new amount" onchange="updateAmount(this)">

    <script>
        const jsonData = [
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "24", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "26", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "25", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "24", name: "Serial Number:1234567890", quantity: "0"}
        ];

        function updateAmount(inputElement) {
            const newAmount = parseFloat(inputElement.value);
            const targetId = inputElement.getAttribute('data-id');

            if (isNaN(newAmount)) {
                console.log("Invalid amount entered.");
                return;
            }

            const index = jsonData.findIndex(item => item.id === targetId);

            if (index !== -1) {
                jsonData[index].amount = newAmount;
                console.log(`Updated amount for ID ${targetId} at index ${index}: ${jsonData[index].amount}`);
                console.log(jsonData);
            } else {
                console.log(`ID ${targetId} not found in the array.`);
            }
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <table id="goods_table">
        <tbody>
            <!-- Rows will be appended here -->
        </tbody>
    </table>

    <script>
        const jsonData = [
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "24", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "26", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "25", name: "Serial Number:1234567890", quantity: "0"},
            {HSNSAC: "8507", amount: 0, amount_per_unit: "20000", brand: "AD", category: "Battery", description: "color:RED", gst: "5", id: "24", name: "Serial Number:1234567890", quantity: "0"}
        ];

        function appendRows() {
            const $tbody = $("#goods_table tbody");
            jsonData.forEach((item, index) => {
                const rowHtml = `
                    <tr>
                        <td>${index + 1}</td>
                        <td><input style="width:100px;" type="text" name="itemCat" value="${item.category}" data-id="${item.id}" onchange="updateField(this, 'category')"></td>
                        <td><input style="width:300px;" type="text" name="itemName" value="${item.name}" data-id="${item.id}" onchange="updateField(this, 'name')"></td>
                        <td><textarea style="width:auto; min-height:30px;height: 30px;" name="itemDesc" data-id="${item.id}" placeholder="Description" onchange="updateField(this, 'description')">${item.description}</textarea></td>
                        <td class="amount"><input style="width:100px;" type="text" name="itemAmount" value="${item.amount_per_unit}" data-id="${item.id}" onchange="updateField(this, 'amount_per_unit')"></td>
                        <td class="quantity"><input style="width:50px;" type="text" name="itemGst" value="${item.gst}" data-id="${item.id}" onchange="updateField(this, 'gst')"></td>
                        <td class="quantity"><input style="width:50px;" type="text" name="itemQty" value="${item.quantity}" data-id="${item.id}" onchange="updateField(this, 'quantity')"></td>
                    </tr>
                `;
                $tbody.append(rowHtml);
            });
        }

        function updateField(element, field) {
            const targetId = $(element).data('id');
            const newValue = $(element).val();
            updateJsonData(targetId, field, newValue);
        }

        function updateJsonData(id, field, value) {
            const index = jsonData.findIndex(item => item.id === id.toString());

            if (index !== -1) {
                jsonData[index][field] = value;
                console.log(`Updated ${field} for ID ${id} at index ${index}: ${jsonData[index][field]}`);
                console.log(jsonData);
            } else {
                console.log(`ID ${id} not found in the array.`);
            }
        }

        // Append rows to the table when the document is ready
        $(document).ready(function() {
            appendRows();
        });
    </script>
</body>
</html>

