export function moneyFormat(money) {
    if( money ){
        return Number((parseFloat(money)).toFixed(6)) + '$';
    }
    return '0$';
}