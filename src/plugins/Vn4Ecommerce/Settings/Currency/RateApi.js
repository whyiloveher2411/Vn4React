import { Button, Typography } from '@material-ui/core'
import { Alert } from '@material-ui/lab'
import { LoadingButton, DialogCustom, FieldForm } from 'components';
import React from 'react'
import { useAjax } from 'utils/useAjax';

function RateApi({ title, description, alertText, post, currencies, onReview, name, setCurrencies }) {

    const [dataObject, setDataObject] = React.useState({
        key: post[name],
        openDialog: false,
        openImport: !Boolean(post[name]),
    });

    const useAjax1 = useAjax();

    const handleSubmitApiSetting = () => {

        if (!useAjax1.open) {

            useAjax1.ajax({
                url: 'plugin/vn4-ecommerce/currencies/currency-converter-api',
                data: {
                    type: name,
                    apiKey: dataObject.key
                },
                success: (result) => {
                    if (!result.error) {

                        onReview(dataObject.key, name);

                        setDataObject(prev => ({
                            ...prev,
                            openDialog: false,
                            openImport: !Boolean(dataObject.key)
                        }))
                    }
                }
            });
        }
    }

    const handleOnCloseDialog = () => {
        setDataObject(prev => ({ ...prev, openDialog: false }))
    }

    const handleOnOpenDialog = () => {
        setDataObject(prev => ({ ...prev, key: post[name], openDialog: true }))
    }

    const handleImportRateCurrency = () => {

        if (!useAjax1.open) {
            useAjax1.ajax({
                url: 'plugin/vn4-ecommerce/currencies/update-rate-api',
                data: {
                    type: name,
                    currencies: currencies
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
                        <Button onClick={handleOnOpenDialog} color="inherit" size="small">
                            Setting
                        </Button>
                        <LoadingButton
                            open={useAjax1.open} variant="text" disabled={dataObject.openImport} onClick={handleImportRateCurrency} color="inherit" size="small"
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
                open={dataObject.openDialog}
                onClose={handleOnCloseDialog}
                action={<>
                    <Button onClick={handleOnCloseDialog} >Cancel</Button>
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
                        post={dataObject}
                        name={'key'}
                        onReview={(value) => {
                            setDataObject(prev => ({ ...prev, key: value }));
                        }}
                    />
                </Typography>

            </DialogCustom>

        </>
    )
}

export default RateApi
