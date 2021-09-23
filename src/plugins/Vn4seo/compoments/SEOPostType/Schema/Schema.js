import { Divider } from '@material-ui/core';
import FieldForm from 'components/FieldForm';
import React from 'react'

const jsonLDType = {
    article: {
        title: 'Article',
        description: 'Tin tức, tin thể thao hoặc bài đăng trên blog xuất hiện trong băng chuyền Tin bài hàng đầu và trong các kết quả nhiều định dạng, chẳng hạn như văn bản tiêu đề và hình ảnh lớn hơn hình thu nhỏ.',
        fields: {
            headline: {
                title: 'Headline',
                view: 'text',
            },
            image: {
                title: 'Image',
                view: 'image',
                multiple: true
            },
            datePublished: {
                title: 'Published Date',
                view: 'date_picker',
            },
            dateModified: {
                title: 'Modified Date',
                view: 'date_picker',
            },
        }
    },
    book: {
        title: 'Book',
        description: 'Các hành động với sách giúp người dùng mua được cuốn sách ngay trong kết quả tìm kiếm cho cuốn sách đó trên Google.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    breadcrumb: {
        title: 'Breadcrumb',
        description: 'Thành phần điều hướng cho biết vị trí của trang trong hệ thống phân cấp trang web.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    carousel: {
        title: 'Carousel',
        description: 'Kết quả nhiều định dạng cho một trang web xuất hiện trong một danh sách hoặc bộ sưu tập tuần tự. Tính năng này phải được kết hợp với một trong những tính năng sau: Công thức, Khóa học, Nhà hàng, Phim.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    course: {
        title: 'Course',
        description: 'Các khóa học giáo dục xuất hiện trong một danh sách dành riêng cho từng nhà cung cấp. Các khóa học có thể cung cấp những thông tin như tên khóa học, nhà cung cấp và phần mô tả ngắn.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'critic-review': {
        title: 'Critic Review',
        description: 'Đoạn trích từ một bài viết đánh giá dài mà một biên tập viên đã tạo, tuyển chọn hoặc tổng hợp cho nhà xuất bản. Bài đánh giá phê bình có thể là về Sách, Phim, hoặc Doanh nghiệp địa phương.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    dataset: {
        title: 'Dataset',
        description: 'Các tập dữ liệu lớn xuất hiện trong Google Tìm kiếm Tập dữ liệu.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'employer-rating': {
        title: 'Employer Rating',
        description: 'Thông tin đánh giá về một tổ chức tuyển dụng (tổng hợp từ nhiều người dùng) xuất hiện trong giao diện tìm kiếm việc làm trên Google.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'estimated-salary': {
        title: 'Estimated Salary',
        description: 'Thông tin ước tính về mức lương, chẳng hạn như phạm vi và mức lương trung bình theo vùng cho các loại công việc, xuất hiện trên giao diện tìm kiếm việc làm trên Google.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    event: {
        title: 'Event',
        description: 'Một kết quả nhiều định dạng giàu tính tương tác, trên đó có danh sách các sự kiện được tổ chức, chẳng hạn như những buổi hòa nhạc hoặc lễ hội nghệ thuật mà mọi người có thể tham dự tại một thời điểm và địa điểm cụ thể.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    factcheck: {
        title: 'Factcheck',
        description: 'Phiên bản tóm tắt của một đánh giá trên một trang web đáng tin cậy liên quan đến một tuyên bố nào đó.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    faqpage: {
        title: 'Faqpage',
        description: 'Trang Câu hỏi thường gặp chứa danh sách các câu hỏi và câu trả lời liên quan đến một chủ đề.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'home-activities': {
        title: 'Home Activities',
        description: 'Một loại kết quả nhiều định dạng giàu tính tương tác cho phép mọi người khám phá những hoạt động trực tuyến họ có thể thực hiện tại nhà.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'how-to': {
        title: 'How to',
        description: 'Một bản Hướng dẫn giúp người dùng thực hiện các bước để hoàn thành một việc, thông qua video, hình ảnh và văn bản.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'image-license-metadata': {
        title: 'Image License Metadata',
        description: 'Trong Google Hình ảnh, huy hiệu Có thể cấp phép cho mọi người biết rằng hình ảnh đó có thông tin giấy phép, đồng thời cung cấp đường liên kết đến giấy phép trong Trình xem hình ảnh để người dùng xem thêm chi tiết về cách thức sử dụng hình ảnh đó.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'job-posting': {
        title: 'Job posting',
        description: 'Một kết quả nhiều định dạng giàu tính tương tác cho phép người dùng tìm việc làm. Trải nghiệm tìm kiếm việc làm trên Google có thể kèm theo biểu trưng, bài đánh giá, điểm xếp hạng và thông tin chi tiết về việc làm.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'job-training': {
        title: 'Job training',
        description: 'Một kết quả nhiều định dạng giàu tính tương tác giúp những người tìm việc và người sắp trở thành sinh viên tìm một chương trình đào tạo nghề.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'local-business': {
        title: 'Local business',
        description: 'Thông tin chi tiết về doanh nghiệp được hiển thị trong bảng tri thức của Google, bao gồm giờ mở cửa, điểm xếp hạng, hướng dẫn đường đi và thao tác đặt lịch hẹn hoặc đặt hàng.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'logo': {
        title: 'Logo',
        description: 'Biểu trưng của tổ chức của bạn trong kết quả tìm kiếm và bảng tri thức của Google.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'math-solvers': {
        title: 'Math solvers',
        description: 'Giúp học sinh, giáo viên và những người khác giải toán bằng cách thêm dữ liệu có cấu trúc để chỉ báo loại bài toán cũng như hướng dẫn từng bước cho các bài toán cụ thể.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'movie': {
        title: 'Movie',
        description: 'Băng chuyền phim giúp người dùng khám phá các danh sách phim trên Google Tìm kiếm (ví dụ: "phim hay nhất năm 2019"). Bạn có thể cung cấp thông tin chi tiết về các phim này, chẳng hạn như nhan đề, đạo diễn, thông tin và hình ảnh của phim.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'practice-problems': {
        title: 'Practice problems',
        description: 'Giúp học sinh, giáo viên và cha mẹ trong quá trình học bằng cách thêm dữ liệu có cấu trúc cho bài tập ôn tập về các môn toán học và khoa học.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'product': {
        title: 'Product',
        description: 'Thông tin về một sản phẩm, bao gồm mức giá, tình trạng còn hàng và đánh giá xếp hạng.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'qapage': {
        title: 'Q&A page',
        description: 'Trang Hỏi đáp là các trang web chứa dữ liệu ở định dạng câu hỏi và câu trả lời, cụ thể là một câu trả lời cho mỗi câu hỏi.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'recipe': {
        title: 'Recipe',
        description: 'Công thức xuất hiện dưới dạng từng kết quả nhiều định dạng hoặc một phần của một băng chuyền chứa cùng loại kết quả.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'review-snippet': {
        title: 'Review snippet',
        description: 'Đoạn trích ngắn từ một bài đánh giá hoặc điểm xếp hạng trên một trang web đánh giá, thường là điểm trung bình của các lượt xếp hạng do nhiều người đánh giá đưa ra. Đoạn trích đánh giá có thể là về Sách, Công thức, Phim, Sản phẩm, Ứng dụng phần mềm, hoặc Doanh nghiệp địa phương.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'sitelinks-searchbox': {
        title: 'Sitelinks searchbox',
        description: 'Hộp tìm kiếm trong phạm vi trang web của bạn khi trang đó xuất hiện dưới dạng một kết quả tìm kiếm.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'software-app': {
        title: 'Software app',
        description: 'Thông tin về một ứng dụng phần mềm, bao gồm thông tin đánh giá, thông tin mô tả ứng dụng và đường liên kết đến ứng dụng.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'speakable': {
        title: 'Speakable',
        description: 'Cho phép các công cụ tìm kiếm và các ứng dụng khác xác định nội dung tin tức để đọc to trên các thiết bị có Trợ lý Google nhờ tính năng chuyển văn bản sang lời nói (TTS).',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'paywalled-content': {
        title: 'Paywalled content',
        description: 'Chỉ ra nội dung có tường phí trên trang web của bạn để giúp Google phân biệt nội dung có tường phí với kỹ thuật che giấu, một hành vi vi phạm các nguyên tắc của chúng tôi.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
    'video': {
        title: 'Video',
        description: 'Thông tin về video trong kết quả tìm kiếm, kèm theo tùy chọn phát video, xác định các đoạn trong video và nội dung phát trực tiếp.',
        fields: {
            headline: {
                title: 'Headline 2',
                view: 'text',
            },
            image: {
                title: 'Image 2',
                view: 'image',
                multiple: true
            },
        }
    },
};


function Schema({ onReview, data }) {

    const [jsonLD, setJsonLD] = React.useState((data.json_ld && jsonLDType[data.json_ld]) ? jsonLDType[data.json_ld] : {});

    return (
        <div>
            <FieldForm
                compoment='select'
                config={{
                    title: 'Json-LD Type',
                    list_option: jsonLDType,
                    displayEmpty: true,
                }}
                post={data}
                name='json_ld'
                onReview={(value) => { console.log(jsonLDType[value]); setJsonLD({ ...jsonLDType[value] }); onReview('json_ld', value) }}
            />
            <Divider style={{ margin: '16px 0' }} />
            {
                Boolean(jsonLD?.fields) &&
                Object.keys(jsonLD.fields).map((key) => (
                    <div key={key} style={{ margin: ' 0 0 24px 0' }}>
                        <FieldForm
                            compoment={jsonLD.fields[key].view}
                            config={jsonLD.fields[key]}
                            post={{}}
                            name={key}
                            onReview={(value) => { }}
                        />
                    </div>
                ))

            }


        </div>
    )
}

export default Schema
