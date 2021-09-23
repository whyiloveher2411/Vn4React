import { Button, Typography } from '@material-ui/core'
import { Alert } from '@material-ui/lab'
import { LoadingButton, DialogCustom, FieldForm } from 'components';
import React from 'react'
import { useAjax } from 'utils/useAjax';

function RateApi({ title, description, alertText, values, setValues, name, setCurrencies }) {

    const [openDialogCurrencyApi, setOpenDialogCurrencyApi] = React.useState(false);

    const useAjax1 = useAjax();

    const handleSubmitApiSetting = () => {
        if (!useAjax1.open) {

            useAjax1.ajax({
                url: 'plugin/vn4-ecommerce/currencies/currency-converter-api',
                data: {
                    type: name,
                    apiKey: values.apiKeys[name]
                },
                success: (result) => {
                    if (result.apiKeys) {
                        setValues(prev => (
                            {
                                ...values,
                                apiKeys: { ...prev.apiKeys, ...result.apiKeys },
                            }
                        ));
                        setOpenDialogCurrencyApi(false);
                    }
                }
            });
        }
    }

    const handleImportByApi = () => {

        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'plugin/vn4-ecommerce/currencies/update-rate-api',
                data: {
                    type: name,
                    currencies: values.currencies
                },
                success: (result) => {
                    if (result.currencies) {
                        setCurrencies(result.currencies);
                    }
                }
            });
        }

    };

    return (
        <>
            <Alert
                style={{ marginBottom: 8 }}
                severity="info"
                action={
                    <>
                        <Button onClick={() => setOpenDialogCurrencyApi(true)} color="inherit" size="small">
                            Setting
                        </Button>
                        <LoadingButton
                            open={useAjax1.open} variant="text" disabled={!Boolean(values.apiKeys[name])} onClick={handleImportByApi} color="inherit" size="small"
                        >
                            Import
                        </LoadingButton>
                    </>
                }
            >
                {alertText}
            </Alert>

            <DialogCustom
                title={title}
                open={openDialogCurrencyApi}
                onClose={() => setOpenDialogCurrencyApi(false)}
                action={<>
                    <Button onClick={() => setOpenDialogCurrencyApi(false)} >Cancel</Button>
                    <LoadingButton
                        open={useAjax1.open} onClick={handleSubmitApiSetting} variant="text" color="primary">
                        Save Changes
                    </LoadingButton>
                </>}
            >

                <Typography variant="body1">
                    {description}
                </Typography>

                <Typography variant="h4" style={{ marginTop: 16 }}>
                    <FieldForm
                        compoment="text"
                        config={{
                            title: 'API key',
                        }}
                        post={values.apiKeys}
                        name={name}
                        onReview={(value) => {
                            setValues(prev => ({ ...prev, apiKeys: { ...prev.apiKeys }, [name]: value }));
                        }}
                    />
                </Typography>

            </DialogCustom>

        </>
    )
}

export default RateApi
