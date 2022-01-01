import { Box, Typography } from '@material-ui/core';
import { AvatarCustom } from 'components';
import React from 'react';

export function Customer({ customer }) {
    return (
        <Box gridGap={16} display="flex" alignItems="center">
            <AvatarCustom image={customer.avatar} name={(customer.first_name ?? '') + ' ' + (customer.last_name ?? '')} />
            <Box display="flex" flexDirection="column">
                <Typography variant="body1">{customer.first_name ?? ''} {customer.last_name ?? ''}</Typography>
                <Typography variant="body2">{customer.title}</Typography>
            </Box>
        </Box>
    )
};

function Main(props) {

    const [customer, setCustomer] = React.useState(false);

    React.useEffect(() => {
        if (props.post.ecom_customer_detail) {
            try {
                setCustomer(JSON.parse(props.post.ecom_customer_detail));
            } catch (error) {

            }

        }
    }, []);

    if (customer) {
        return <Customer customer={customer} />
    }
    return null;
}


export default Main
