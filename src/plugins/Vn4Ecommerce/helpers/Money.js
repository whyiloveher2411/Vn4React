import { numberWithSeparator } from "utils/helper";

export function moneyFormat(money, $isSpace = false) {
    
    if (money) {
        return '$' + ($isSpace ? ' ' : '') + numberWithSeparator(Number((parseFloat(money)).toFixed(2)));
    }
    return '$' + ($isSpace ? ' ' : '') + '0';
}

export const calculateProfit = (price, cost) => {
    if (price && cost) {

        return {
            money: price - cost,
            margin: Number(((parseFloat(price) - parseFloat(cost)) / parseFloat(price) * 100).toFixed(1))
        };

    } else {
        return false;
    }
}

export const precentFormat = (precent) => {
    return Number(precent).toFixed(1) + '%';
}

export const calculatePercentDiscount = (compare_price, price) => {

    if (compare_price && price) {
        return Number(100 - (price * 100 / (compare_price ?? 1))).toFixed(1) + '%';
    } else {
        return false;
    }
}

export const calculateTax = (price, percentage) => {
    return Number((parseFloat(percentage / 100 * parseFloat(price))).toFixed(6));
}

export const calculatePricing = ({ price = 0, compare_price = 0, cost = 0, enable_tax, tax_class_detail, tax_class }) => {

    let profit = (Number(price - cost).toFixed(2)) * 1;
    let profit_margin = (Number((parseFloat(price) - parseFloat(cost)) / parseFloat(price) * 100).toFixed(2)) * 1;

    let percent_discount = 0;

    if (compare_price > 0) {
        percent_discount = (Number(100 - (price * 100 / (compare_price ?? 1))).toFixed(1)) * 1;
    }

    let tax = 0;

    if (enable_tax === undefined || enable_tax) {

        if (typeof tax_class_detail !== 'object') {
            try {
                tax_class_detail = JSON.parse(tax_class_detail);
            } catch (error) {
                tax_class_detail = {
                    percentage: 0
                };
            }
        }

        if (tax_class_detail?.percentage) {
            tax = Number(parseFloat(tax_class_detail.percentage / 100 * parseFloat(price))).toFixed(3);
        }

    }

    let price_after_tax = (Number(parseFloat(price) + parseFloat(tax)).toFixed(2)) * 1;

    return {
        price,
        compare_price,
        cost,
        enable_tax,
        tax_class,
        tax_class_detail,

        profit,
        profit_margin,
        percent_discount,
        tax,
        price_after_tax,
    };
}