import React from 'react';
import { CommingSoon, Page, DataTable, Header } from 'components';
import { Divider } from '@material-ui/core';

const Notifications = () => {
    return (
        <Page
            title="Notifications"
        >
            <Header
                title="Notifications"
                subTitle="Notifications"
            />
            <div style={{ marginTop: 24 }}>
                <DataTable />
            </div>
        </Page>
    );
};

export default Notifications;
