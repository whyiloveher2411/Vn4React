import { Box } from '@material-ui/core';
import { Alert, Skeleton } from '@material-ui/lab';
import { FieldForm, LoadingButton } from 'components';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import RateApi from './compoments/Currencies/RateApi';

function Currencies({ ajaxPluginHandle, loading }) {

    const [currenciesList, setCurrenciesList] = React.useState(false);

    const [values, setValues] = React.useState({ currencies: [], apiKey: false, apiKeys: {} });

    const { showNotification } = useAjax();

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

                // codes.push(item.currencie_code);
                // valueTemp.push({ ...item, symbol: currenciesList[item.currencie_code] ? currenciesList[item.currencie_code].symbol : '' });

                codes.push(item.currencie_code);
                valueTemp.push({ ...item });

            } else {
                valueTemp.push({ ...item, currencie_code: '' });
                if (currenciesList[item.currencie_code]) {
                    showNotification(currenciesList[item.currencie_code].name + ' added before, change it instead of adding new', 'warning');
                }
            }
        });

        console.log({
            currencies: [
                ...valueTemp
            ]
        });

        setValues(prev => ({
            ...values,
            currencies: [
                ...valueTemp
            ]
        }));
    }

    const handleSubmit = () => {
        if (!loading.open) {
            ajaxPluginHandle({
                url: 'currencies/settings',
                data: {
                    currencies: values.currencies,
                    action: 'SettingCurrencies'
                },
                success: (result) => {
                    if (result.currencies) {
                        setCurrencies(result.currencies);
                    }
                }
            });
        }
    };


    React.useEffect(() => {

        ajaxPluginHandle({
            url: 'currencies/settings',
            data: {
                action: 'LoadingCurrencies'
            },
            success: (result) => {

                if (result.currenciesList) {
                    setCurrenciesList(result.currenciesList);
                }

                if (result.currencies) {
                    setCurrencies(result.currencies, {
                        apiKeys: result.apiKeys
                    });
                } else {
                    setCurrencies(
                        {
                            USD: {
                                currencie_code: 'USD',
                                symbol: result.currenciesList.USD.symbol,
                                number_of_decimals: result.currenciesList.USD.number_of_decimals,
                                rate: 1.0000
                            }
                        },
                        {
                            apiKeys: result.apiKeys
                        }
                    );
                }
            }
        });

    }, []);

    if (currenciesList) {
        return (
            <SettingEdit1
                title="Currencies"
                titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                    <span>Currencies</span>
                    <LoadingButton
                        className={'btn-green-save'}
                        onClick={handleSubmit}
                        variant="contained"
                        open={loading.open}
                    >
                        Save Changes
                    </LoadingButton>
                </Box>}
                backLink="/plugin/vn4-ecommerce/settings"
                description="List of Currency code by Countries, International Currencies, currency names and ... Below you will find a list of money in use for each country"
            >
                <Alert style={{ marginBottom: 6 }} severity="warning">
                    The currency in the first place will be used as the default currency, when updating rate using the API will default to 1
                </Alert>
                <Alert style={{ marginBottom: 6 }} severity="warning">
                    All invalid currency will not appear in the front view
                </Alert>
                <RateApi
                    title="free.currconv.com"
                    description={
                        <>
                            Accurate API for current and historical exchange rates. Track exchange rates of multiple currencies in real-time. Accurate Rates. Flexible Packages. 170+ Currencies.
                            (<a href="https://www.currencyconverterapi.com/" target="_blank">Get Here</a>)
                        </>
                    }
                    alertText="Import Service by Currency Converter API"
                    values={values}
                    setValues={setValues}
                    name="free.currconv.com"
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
                    values={values}
                    setValues={setValues}
                    name="exchangerate-api.com"
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
                                list_option: currenciesList,
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
            </SettingEdit1>
        )
    }


    return (
        <SettingEdit1
            title="Currencies"
            titleComponent={<Skeleton variant="rect" width={'100%'} height={42} />}
            description={
                <>
                    <Skeleton variant="text" style={{ marginBottom: 6 }} width={'100%'} height={24} />
                    <Skeleton variant="text" style={{ marginBottom: 6 }} width={'100%'} height={24} />
                </>
            }
        >
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
        </SettingEdit1>
    )
}

export default Currencies