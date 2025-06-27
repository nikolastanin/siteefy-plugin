document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('post'); // WordPress post form
    const categoryChecklist = document.getElementById('categorychecklist');
    const solutionChecklist = document.getElementById('solutionchecklist');

    if (!form || !categoryChecklist || !solutionChecklist) return;

    form.addEventListener('submit', function(e) {
        const categoryBoxes = categoryChecklist.querySelectorAll('input[type="checkbox"]');
        const solutionBoxes = solutionChecklist.querySelectorAll('input[type="checkbox"]');

        const isCategoryChecked = Array.from(categoryBoxes).some(cb => cb.checked);
        const isSolutionChecked = Array.from(solutionBoxes).some(cb => cb.checked);

        if (!isCategoryChecked || !isSolutionChecked) {
            e.preventDefault();

            let message = 'You must select at least:\n';
            if (!isCategoryChecked) message += '- One Category\n';
            if (!isSolutionChecked) message += '- One Solution';

            alert(message);
        }
    });


});