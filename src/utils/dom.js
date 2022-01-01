export function addClasses(classList) {
    let classesResult = '';

    Object.keys(classList).forEach(key => {
        if (key && classList[key]) {
            classesResult += key + ' ';
        }
    });
    return classesResult;
}