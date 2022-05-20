
window.resetValidMark = (section = document) => {
    const validMarks = section.querySelectorAll('.is-invalid');
    const customValidMarks = section.querySelectorAll('.custom-isvaild');
    for(let i=0; i<validMarks.length; i++) {
        validMarks[i].classList.remove('is-invalid');
    }
    for(let i=0; i<customValidMarks.length; i++) {
        customValidMarks[i].classList.remove('custom-isvaild');
    }
};
