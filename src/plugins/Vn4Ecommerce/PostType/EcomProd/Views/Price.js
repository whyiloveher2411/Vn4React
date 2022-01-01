import React from 'react'
import { moneyFormat } from 'plugins/Vn4Ecommerce/helpers/Money';

function Price(props) {

    if (props.post.product_type === 'variable') {
        return (
            <div>
                {
                    props.post.compare_price_min !== props.post.compare_price_max ?
                        <>
                            <del style={{ textDecoration: 'line-through', color: 'red' }}>{moneyFormat(props.post.compare_price_min)} - {moneyFormat(props.post.compare_price_max)}</del> -
                        </>
                        :
                        <>
                            <del style={{ textDecoration: 'line-through', color: 'red' }}>{moneyFormat(props.post.compare_price_min)}</del> -
                        </>
                }
                {
                    props.post.price_min !== props.post.price_max ?
                        <span style={{ color: 'green', fontWeight: 'bold' }}> {moneyFormat(props.post.price_min)} - {moneyFormat(props.post.price_max)}</span>
                        :
                        <span style={{ color: 'green', fontWeight: 'bold' }}> {moneyFormat(props.post.price_min)}</span>
                }
            </div>
        )
    }

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
