import React from 'react'
import { FieldForm } from 'components';

function Orders({ data }) {
    return (
        <FieldForm
            compoment={'relationship_onetomany_show'}
            config={{
                title: 'Orders',
                object: 'ecom_order',
                field: 'ecom_customer',
                view: "relationship_onetomany_show",
                showFields: {
                    title: {
                        title: 'ID',
                        view: 'text'
                    },
                    total_money: {
                        title: 'Total Money',
                        view: 'text',
                    },
                    created_at: {
                        title: 'Created At',
                        view: 'date_picker'
                    }
                }
            }}
            post={data.post}
            name={'ecom_customer'}
            onReview={(value) => { }}
        />
    )
}

export default Orders
