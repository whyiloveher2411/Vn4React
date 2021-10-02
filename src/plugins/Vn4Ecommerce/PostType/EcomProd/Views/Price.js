import React from 'react'
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';

function Price(props) {

    return (
        <div>
            {
                Boolean(props.post.compare_price) &&
                <>
                    <del style={{ textDecoration: 'line-through', color: 'red' }}>{moneyFormat(props.post.compare_price)}</del> -
                </>
            }
            <span style={{ color: 'green', fontWeight: 'bold' }}> {moneyFormat(props.post.price)}</span>
        </div>
    )
}

export default Price
