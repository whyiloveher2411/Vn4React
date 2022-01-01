import { Alert, Skeleton } from '@material-ui/lab';
import { FieldForm } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import RateApi from './RateApi';

function Currencies({ post, name, config, onReview }) {

    const [currenciesList, setCurrenciesList] = React.useState(false);

    const [values, setValues] = React.useState({ currencies: [], apiKey: false, apiKeys: {} });

    const { ajax, showNotification } = useAjax();

    const setCurrencies = (currencies, defautValue = {}) => {
        if (currencies && typeof currencies === 'object') {

            let currenciesTemp = Object.keys(currencies).map(key => ({ ...currencies[key] }));

            values.currencies.forEach((item, index) => {
                currenciesTemp[index].open = item.open;
            });

            setValues({
                ...values,
                ...defautValue,
                currencies: currenciesTemp
            });

        }
    };



    const validatecurrencies = (currencies) => {

        let valueTemp = [];
        let codes = [];

        currencies.forEach((item) => {

            if (codes.indexOf(item.currencie_code) === -1) {

                codes.push(item.currencie_code);
                valueTemp.push({ ...item });

            } else {
                valueTemp.push({ ...item, currencie_code: '' });
                if (currenciesList[item.currencie_code]) {
                    showNotification(currenciesList[item.currencie_code].name + ' added before, change it instead of adding new', 'warning');
                }
            }
        });

        onReview(valueTemp, name);
    }

    React.useEffect(() => {

        if (post[name]) {

            if (typeof post[name] === 'object' && post[name]) {
                setCurrencies(post[name]);
            } else if (typeof post[name] === 'string') {
                let currency = {};
                try {
                    currency = JSON.parse(post[name]) || {};
                } catch (error) {
                    currency = {};
                }

                setCurrencies(currency);
            }
        }

    }, []);

    return (
        <>
            <Alert style={{ marginBottom: 6 }} severity="warning">
                The currency in the first place will be used as the default currency, when updating rate using the API will default to 1
            </Alert>
            <Alert style={{ marginBottom: 6 }} severity="warning">
                All invalid currency will not appear in the front view
            </Alert>
            <RateApi
                title="currencyconverterapi.com"
                description={
                    <>
                        Accurate API for current and historical exchange rates. Track exchange rates of multiple currencies in real-time. Accurate Rates. Flexible Packages. 170+ Currencies.
                        (<a href="https://www.currencyconverterapi.com/" target="_blank">Get Here</a>)
                    </>
                }
                alertText="Import Service by Currency Converter API"
                post={post}
                onReview={onReview}
                name="currency/currencyconverter/api_key"
                currencies={values.currencies}
                setCurrencies={setCurrencies}
            />

            <RateApi
                title="exchangerate-api.com"
                description={
                    <>
                        ExchangeRate-API is a totally free & unlimited currency conversion API.
                        (<a href="https://www.exchangerate-api.com/" target="_blank">Get Here</a>)
                    </>
                }
                alertText="Import Service by Exchangerate API"
                post={post}
                onReview={onReview}
                currencies={values.currencies}
                name="currency/exchangerate/api_key"
                setCurrencies={setCurrencies}
            />

            <br />

            <FieldForm
                compoment="repeater"
                config={{
                    title: 'Currencies',
                    layout: 'block',
                    actions: values.currencies.length > 1 ? {
                        delete: values.currencies.length > 1 ? true : false,
                    } : 'none',
                    sub_fields: {
                        currencie_code: {
                            title: 'Currencies',
                            view: 'select',
                            list_option: config.currenciesList,
                        },
                        symbol: { title: 'Symbol', view: 'text' },
                        number_of_decimals: { title: 'Number of decimals', view: 'number' },
                        rate: {
                            title: 'Rate',
                            view: 'number',
                            note: 'Rate may change when you update using the api'
                        },

                    },
                    singular_name: 'Currencie'
                }}
                post={values}
                name="currencies"
                onReview={validatecurrencies}
            />
        </>
    )

    return (
        <>
            <Skeleton variant="rect" style={{ marginBottom: 6 }} width={'100%'} height={48} />
            <Skeleton variant="rect" style={{ marginBottom: 6 }} width={'100%'} height={48} />
            <Skeleton variant="rect" style={{ marginBottom: 6 }} width={'100%'} height={48} />
            <Skeleton variant="rect" style={{ marginBottom: 32 }} width={'100%'} height={48} />

            <Skeleton variant="text" width={'100%'} style={{ marginBottom: 8 }} height={14} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
            <Skeleton variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
        </>
    )
}

export default Currencies