import React from 'react'
import SettingEdit1 from 'components/Setting/SettingEdit1';
import { Box } from '@material-ui/core';
import { LoadingButton } from 'components';

function General({ loading }) {
    return (
        <SettingEdit1
            title="General"
            titleComponent={<Box width={1} display="flex" justifyContent="space-between">
                <span>General</span>
                <LoadingButton
                    className={'btn-green-save'}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>}
            backLink="/plugin/vn4-ecommerce/settings"
            description="View and update your store details"
        >

        </SettingEdit1>
    )
}

export default General
