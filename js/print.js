window.jsPDF = window.jspdf.jsPDF;
var doc = new jsPDF();

// document.getElementById('generate-pdf').addEventListener('click', async () => {
//     const doc = new jsPDF();
//     const element = document.getElementById('table-place');
//     const canvas = await html2canvas(element, { scale: 2 });
//     const imgData = canvas.toDataURL('image/png');
//
//     const pageWidth = doc.internal.pageSize.getWidth();
//     const pageHeight = doc.internal.pageSize.getHeight();
//     const imgWidth = canvas.width;
//     const imgHeight = canvas.height;
//
//     const scale = Math.min(pageWidth / imgWidth, pageHeight / imgHeight);
//     const imgX = (pageWidth - imgWidth * scale) / 2;
//     const imgY = 10; // Adjust Y position as needed
//
//     doc.addImage(imgData, 'PNG', imgX, imgY, imgWidth * scale, imgHeight * scale);
//     doc.save('document.pdf');
// });

/* document.getElementById('generate-pdf').addEventListener('click', () => {
    const doc = new jsPDF();

    const element = document.getElementById("table-place");
    const pageWidth = doc.internal.pageSize.getWidth() - 20;
    const pageHeight = doc.internal.pageSize.getHeight() - 20;
    const elementWidth = element.scrollWidth;
    const elementHeight = element.scrollHeight;

    // Calculate scale to fit the content within the PDF page
    const scaleX = pageWidth / elementWidth;
    const scaleY = pageHeight / elementHeight;
    const scale = Math.min(scaleX, scaleY);

    doc.html(element, {
        callback: function (doc) {
            doc.save("document.pdf");
        },
        x: 10,
        y: 10,
        html2canvas: {
            scale: scale,
            useCORS: true,
            width: elementWidth,
            height: elementHeight
        },
        width: pageWidth - 20, // Adjust width to consider margins
        windowWidth: elementWidth
    });
}); */

document.getElementById('generate-pdf').addEventListener('click', () => {
    const doc = new jsPDF();
    const element = document.getElementById("table-place");

    // Ensure element is visible and has correct dimensions
    element.style.display = 'block'; // Ensure element is visible for accurate measurement

    // Calculate page dimensions
    const pageWidth = doc.internal.pageSize.getWidth() - 20;
    const pageHeight = doc.internal.pageSize.getHeight() - 20;

    // Calculate element dimensions
    const elementWidth = element.clientWidth;  // Use clientWidth to exclude padding
    const elementHeight = element.clientHeight;  // Use clientHeight to exclude padding

    // Calculate scale to fit the content within the PDF page
    const scaleX = pageWidth / elementWidth;
    const scaleY = pageHeight / elementHeight;
    const scale = Math.min(scaleX, scaleY);

    // Generate PDF from HTML element
    doc.html(element, {
        callback: function (doc) {
            doc.save("document.pdf");
            element.style.display = ''; // Restore element display style
        },
        x: 10,
        y: 10,
        html2canvas: {
            scale: scale,
            useCORS: true
        },
        width: pageWidth - 20, // Adjust width to consider margins
        windowWidth: elementWidth
    });
});

/* document.getElementById('generate-pdf').addEventListener('click', () => {
    const doc = new jsPDF();

    const element = document.getElementById("table-place");
    const pageWidth = doc.internal.pageSize.getWidth();
    const pageHeight = doc.internal.pageSize.getHeight();
    const elementWidth = element.scrollWidth;
    const elementHeight = element.scrollHeight;

    // Calculate scale to fit the content within the PDF page
    const scaleX = pageWidth / elementWidth;
    const scaleY = pageHeight / elementHeight;
    const scale = Math.min(scaleX, scaleY);

    // Log debug information
    console.log('Page width:', pageWidth);
    console.log('Page height:', pageHeight);
    console.log('Element width:', elementWidth);
    console.log('Element height:', elementHeight);
    console.log('Scale X:', scaleX);
    console.log('Scale Y:', scaleY);
    console.log('Scale:', scale);

    html2canvas(element, {
        scale: scale * 4,
        useCORS: true,
        width: elementWidth,
        height: elementHeight
    }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = canvas.width * scale;
        const imgHeight = canvas.height * scale;

        // Center the image
        const x = (pageWidth - imgWidth) / 2;
        const y = (pageHeight - imgHeight) / 2;

        doc.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);
        doc.save('document.pdf');
    });
}); */
