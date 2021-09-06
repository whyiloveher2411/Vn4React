import React from 'react'
import { FieldForm } from 'components';

function Reviews({data}) {
    return (
        <FieldForm
            compoment={'relationship_onetomany_show'}
            config={{
                title: 'Reviews',
                object: 'ecom_prod_review',
                field: 'ecom_customer',
                view: "relationship_onetomany_show"
            }}
            post={data.post}
            name={'ecom_customer'}
            onReview={(value) => { }}
        />
    )
}

export default Reviews
