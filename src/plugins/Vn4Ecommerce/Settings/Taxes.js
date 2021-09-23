import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function Taxes({ loading }) {
    return (
        <SettingEdit1
            title="Taxes"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>Taxes</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="Manage how your store charges taxes"
        >

        </SettingEdit1>
    )
}

export default Taxes
