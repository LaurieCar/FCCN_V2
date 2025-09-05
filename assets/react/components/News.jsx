import React, { useEffect, useState } from 'react';

const News = () => {

    const [news, setNews] = useState([]);

    useEffect(() => {
        console.log('ok');
        // appel de l'api
        fetch('/news')
            .then(response => {
                console.log('reponse ok');
                return response.json();
            })
            .then(data => {
                console.log('donnees ok');
                setNews(data);
            });
    }, []);

    return (
        <section className='flex flex-col ml-10 px-40 pt-32'>
            <h2 className='text-redFccn font-quicksand font-bold text-2xl'>NOS ACTUALITÉS</h2>
            <p className='font-tahoma my-6 text-gray-600'>Retrouvez-ici les dernières actualités du Football Club Canal Nord !</p>

            <div className='grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6'>
                {news.map(article => (
                    <article key={article.id} className='rounded-lg shallow-md overflow-hidden'>
                        {article.image && (
                        <img 
                            src={article.image} 
                            alt={article.title}
                            className="w-full h-48 object-cover"
                        />
                        )}
                        <div className='p-4'>
                            <h3 className='text-lg font-bold mb-2 text-blueFccn font-quicksand'>{article.title}</h3>
                            <p className='font-tahoma text-gray-600 mb-4'>{article.content}</p>
                            <span className="text-gray-500">{article.createdAt}</span>
                        </div>
                    </article>
                ))}
            </div>
        </section>
        
    )
}

export default News;