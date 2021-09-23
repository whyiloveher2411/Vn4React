import { Box, Button, Typography } from '@material-ui/core';
import { Alert, Skeleton } from '@material-ui/lab';
import { DialogCustom, FieldForm, LoadingButton } from 'components';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import Table from '@material-ui/core/Table';
import TableBody from '@material-ui/core/TableBody';
import TableCell from '@material-ui/core/TableCell';
import TableContainer from '@material-ui/core/TableContainer';
import TableHead from '@material-ui/core/TableHead';
import TableRow from '@material-ui/core/TableRow';
import Paper from '@material-ui/core/Paper';
import { Link } from 'react-router-dom';

function Currencies({ meta, ajaxPluginHandle, loading }) {

    const [openDialog, setOpenDialog] = React.useState(false);

    const [currenciesList, setCurrenciesList] = React.useState(false);

    const [values, setValues] = React.useState({ currencies: [] });

    const { showNotification } = useAjax();

    const setCurrencies = (currencies) => {
        if (currencies && typeof currencies === 'object') {
            setValues({
                currencies: Object.keys(currencies).map(key => ({ ...currencies[key] }))
            });
        }
    };

    const handleSubmit = () => {
        if (!loading.open) {
            ajaxPluginHandle({
                url: 'settings/currencies',
                data: values,
                success: (result) => {
                    if (result.currencies) {
                        setCurrencies(result.currencies);
                        setOpenDialog(false);
                    }
                }
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
            currencies: [
                ...valueTemp
            ]
        }));
    }

    React.useEffect(() => {

        ajaxPluginHandle({
            url: 'settings/currencies',
            data: {
                action: 'LoadingCurrencies'
            },
            success: (result) => {
                if (result.currenciesList) {
                    setCurrenciesList(result.currenciesList);
                }
                setCurrencies(result.currencies);
                if (result.currencies) {
                    setCurrencies(result.currencies);
                } else {
                    setCurrencies({
                        USD: {
                            currencie_code: 'USD',
                            symbol: result.currenciesList.USD.symbol,
                            number_of_decimals: result.currenciesList.USD.number_of_decimals,
                            rate: 1.0000
                        }
                    });
                }
            }
        });

    }, []);
    console.log(values.currencies);
    if (currenciesList) {
        return (
            <SettingEdit1
                title="Currencies"
                titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                    <span>Currencies</span>
                    <LoadingButton
                        className={'btn-green-save'}
                        onClick={() => setOpenDialog(true)}
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
                    Currency in the first place will be used as the default currency
                </Alert>
                <Alert style={{ marginBottom: 6 }} severity="warning">
                    All invalid currency will not appear in the front view
                </Alert>
                <Alert
                    style={{ marginBottom: 32 }}
                    severity="info"
                    action={
                        <>
                            <Button color="inherit" size="small">
                                Setting
                            </Button>
                            <Button color="inherit" size="small">
                                Import
                            </Button>
                        </>
                    }
                >
                    Import Service Currency Converter API
                </Alert>

                <TableContainer component={Paper}>
                    <Table aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell>Currency</TableCell>
                                <TableCell align="right">Rate</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {
                                Boolean(values.currencies.length > 0) ?
                                    values.currencies.map((currencie) => (
                                        <TableRow>
                                            <TableCell component="th" scope="row">
                                                {currencie.currencie_code}
                                            </TableCell>
                                            <TableCell align="right">
                                                <div style={{ maxWidth: 150, display: 'inline-block' }}>
                                                    <FieldForm
                                                        compoment="text"
                                                        config={{
                                                            title: '',
                                                            size: 'small'
                                                        }}
                                                        post={currencie}
                                                        name="rate"
                                                        onReview={() => { }}
                                                    />
                                                </div>

                                            </TableCell>
                                        </TableRow>
                                    ))
                                    :
                                    <TableRow>
                                        <TableCell colSpan="2" >
                                            <Typography align="center" variant="body1">
                                                No currency found, please set currencies before configuring currency rate <br />
                                                <Link to="/plugin/vn4-ecommerce/settings/currencies" >
                                                    <Button color="primary" >Settings Currencies</Button>
                                                </Link>
                                            </Typography>
                                        </TableCell>
                                    </TableRow>
                            }
                        </TableBody>
                    </Table>
                </TableContainer>

                <DialogCustom
                    title="Currency Converter API"
                    open={openDialog}
                    onClose={() => setOpenDialog(false)}
                    action={<>
                        <Button onClick={() => setOpenDialog(false)} >Cancel</Button>
                        <Button onClick={handleSubmit} color="primary">Save Changes</Button>
                    </>}
                >
                    <Typography variant="h4" style={{ marginBottom: 8 }}>Have you checked the complete information?</Typography>
                    <Typography variant="body1">
                        Once you save your changes, any invalid currency will be removed from the website's currency list.
                    </Typography>
                </DialogCustom>


                <DialogCustom
                    title="Are you sure?"
                    open={openDialog}
                    onClose={() => setOpenDialog(false)}
                    action={<>
                        <Button onClick={() => setOpenDialog(false)} >Cancel</Button>
                        <Button onClick={handleSubmit} color="primary">Save Changes</Button>
                    </>}
                >
                    <Typography variant="h4" style={{ marginBottom: 8 }}>Have you checked the complete information?</Typography>
                    <Typography variant="body1">
                        Once you save your changes, any invalid currency will be removed from the website's currency list.
                    </Typography>
                </DialogCustom>
                {/* DialogCustom({title, content, action, open, onClose, children, ...rest }) */}
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