export function showSuccessToast(meldung){
    M.toast({ html: meldung, classes: 'grey darken-2' });
}
export function showErrorToast(meldung) {
    M.toast({ html: meldung, classes: 'red darken-2' });
}
export function showWarnToast(meldung) {
    M.toast({ html: meldung, classes: 'amber darken-2 black-text' });
}