const items = [
    { Div: "edit-remove-table", Button: "edit-product" },
    { Div: "add-product-div", Button: "add-product" }
];
function display(item) {
    if(item == 0) {
        var x = document.getElementById(items[0].Div);
        var y = document.getElementById(items[1].Div);

        x.style.display = "block";
        y.style.display = "none";
        document.getElementById(items[1].Button).style.fontWeight = 'bold';
        document.getElementById(items[0].Button).style.fontWeight = 'normal';
    }
    if(item == 1) {
        var x = document.getElementById(items[1].Div);
        var y = document.getElementById(items[0].Div);

        x.style.display = "block";
        y.style.display = "none";
        document.getElementById(items[0].Button).style.fontWeight = 'bold';
        document.getElementById(items[1].Button).style.fontWeight = 'normal';
    }
}