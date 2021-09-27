import { Box, Typography } from '@material-ui/core';
import { AvatarCustom, FieldForm } from 'components'
import React from 'react'
import { getImageUrl } from 'utils/image';
import { useAjax } from 'utils/useAjax';

function CustomerTemplate(props) {

    return <Box marginTop={2} gridGap={16} display="flex">
        <div>
            <AvatarCustom variant="square" style={{ width: 250, height: 250, borderRadius: 4 }} image={props.customer.avatar} name={(props.customer.first_name ?? '') + ' ' + (props.customer.last_name ?? '')} />
        </div>
        <Box gridGap={8} display="flex" flexDirection="column">
            <Typography variant="h4">{props.customer.first_name ?? ''} {props.customer.last_name ?? ''}</Typography>
            <Typography variant="body1">{props.customer.title}</Typography>
        </Box>
    </Box>
}

function Customer(props) {

    const { post, onReview } = props;

    const [customer, setCustomer] = React.useState(props.config.__Vn4EcomCustomer ?? false);

    const { ajax, Loading, open } = useAjax({ loadingType: 'custom' });

    const handleLoadCustomer = (id) => {

        if (id) {
            ajax({
                url: 'plugin/vn4-ecommerce/customer/get',
                data: {
                    id: id
                },
                success: (result) => {
                    if (result.customer) {
                        props.config.__Vn4EcomCustomer = result.customer;
                        setCustomer(result.customer);
                    }
                }
            });
        } else {
            props.config.__Vn4EcomCustomer = null;
            setCustomer(false);
        }
    }

    React.useEffect(() => {
        if (post.ecom_customer && !props.config.__Vn4EcomCustomer) {
            handleLoadCustomer(post.ecom_customer);
        }
    }, [post.id]);

    return (
        <>
            <FieldForm
                compoment="relationship_onetomany"
                config={{
                    title: "Customer",
                    object: "ecom_customer"
                }}
                post={post}
                name={'ecom_customer'}
                onReview={(value, key) => {
                    onReview(value, key);
                    handleLoadCustomer(key.ecom_customer);
                }}
            />
            <div style={{ position: 'relative', minHeight: open ? 250 : 0 }}>
                {
                    open &&
                    <Box position="absolute" display="flex" alignItems="center" justifyContent="center" width={1} height={250} >
                        {Loading}
                    </Box>
                }
                {
                    Boolean(customer) &&
                    <CustomerTemplate customer={customer} />
                }
            </div>
        </>
    )
}

export default Customer
