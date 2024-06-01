window.jsPDF = window.jspdf.jsPDF;
var doc = new jsPDF();

document.getElementById('generate-pdf').addEventListener('click', () => {
    const doc = new jsPDF();

    
    doc.html(document.getElementById("content-real"), {
        callback: function (doc) {
            doc.save();
        }
    });
    // doc.text("Hello world!", 10, 10);
    // doc.save("a4.pdf");

});
