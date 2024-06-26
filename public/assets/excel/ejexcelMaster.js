const data = [];
const minDimensions = [15, 10];
let columns = [
    {
        type: "calendar",
        title: "Order Date",
        width: 180,
    },

    {
        type: "text",
        title: "Store Name",
        width: 180,
    },
    {
        type: "dropdown",
        title: "Warehouse *",
        width: 180,
    },
    {
        type: "text",
        title: "Customer Name *",
        width: 180,
    },
    {
        type: "numeric",
        title: "Customer Phone *",
        width: 180,
    },
    {
        type: "numeric",
        title: "Customer Phone 2",
        width: 180,
    },
    {
        type: "text",
        title: "Customer Email",
        width: 180,
    },
    {
        type: "dropdown",
        title: "Customer Country *",
        width: 180,
    },
    {
        type: "text",
        title: "Customer City",
        width: 180,
    },
    {
        type: "text",
        title: "Customer Address",
        width: 180,
    },
    {
        type: "dropdown",
        title: "Items SKU *",
        width: 180,

    },
    {
        type: "numeric",
        title: "Quantity *",
        width: 180,
    },
    {
        type: "numeric",
        title: "Total *",
        width: 180,
    },
    {
        type: "dropdown",
        title: "Currency *",
        source: ["AED", "BHD", "KWD", "MAD", "OMR", "SAR", "USD", "XOF"],
        width: 180,
    },
    {
        type: "text",
        title: "Notes",
        width: 180,
    },
];

document.addEventListener("DOMContentLoaded", function () {

    const countries = document.querySelector(`.excel_container`).getAttribute("data-country");
    const sku = document.querySelector(`.excel_container`).getAttribute("data-sku");

    console.log(countries);

    columns[2].source = countries.split(",");
    columns[7].source = countries.split(",");
    columns[10].source = sku.split(",");

});


let myTable = jspreadsheet(document.getElementById("spreadsheet"), {
    data: data,
    minDimensions: minDimensions,
    columns: columns,
});
