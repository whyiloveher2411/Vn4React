import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Legal({ loading }) {
    return (
        <SettingEdit1
            title="Legal"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Legal</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Manage your store's legal pages"
        >

        </SettingEdit1>
    )
}

export default Legal
