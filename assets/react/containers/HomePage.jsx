import React from "react";
import News from "../components/News";
import Slider from "../components/Slider";

const HomePage = () => {

    return (
        <div className="mt-40">
            <section><Slider/></section>
            <section className="mt-12 mx-auto max-w-screen-2xl px-20">
                <h2 className='text-redFccn font-quicksand font-bold text-2xl uppercase'>Bienvenue sur le site officiel du Football Club Canal Nord !</h2>
                <div className="flex flex-col lg:flex-row gap-14">
                    <div className="flex flex-col w-1/2">
                        <p className="font-tahoma my-6 text-gray-600">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris hendrerit tincidunt nulla congue auctor. Fusce posuere nunc nec nulla lacinia condimentum. 
                    Proin viverra turpis sit amet mauris lobortis, eget tempus risus egestas. Suspendisse sapien ligula, gravida in est et, suscipit suscipit nibh. 
                    Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc ultricies est sem, eget condimentum tellus accumsan sit amet. 
                    Praesent sed dui volutpat, tempus nisi at, mollis lectus. Vestibulum rutrum gravida facilisis. Aliquam diam nisl, mattis eu mi eget, semper hendrerit libero. 
                    Donec pulvinar nibh nisi, sed cursus risus vehicula viverra. Suspendisse dignissim cursus suscipit. Nam luctus ex eu velit pretium mattis. 
                    Integer odio lorem, commodo vitae maximus ut, venenatis sit amet nisi. Suspendisse eu lacinia justo. Suspendisse sed dui eget diam vehicula lobortis vel at lacus. In viverra tincidunt neque. 
                    Vestibulum laoreet elit nec sapien porttitor, at malesuada mi dapibus. Phasellus sit amet ex vel tellus laoreet elementum quis vitae purus. Nunc accumsan lacus libero, id pharetra nunc ornare sit amet.
                    </p>
                    <p className="font-tahoma my-6 text-gray-600">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris hendrerit tincidunt nulla congue auctor. Fusce posuere nunc nec nulla lacinia condimentum. 
                    Proin viverra turpis sit amet mauris lobortis, eget tempus risus egestas. Suspendisse sapien ligula, gravida in est et, suscipit suscipit nibh. 
                    Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc ultricies est sem, eget condimentum tellus accumsan sit amet. 
                    Praesent sed dui volutpat, tempus nisi at, mollis lectus. Vestibulum rutrum gravida facilisis. Aliquam diam nisl, mattis eu mi eget, semper hendrerit libero.
                    </p>
                    </div>
                    
                    <div className="flex flex-col w-1/2 mt-10 space-y-6">
                        <div className="w-full aspect-video border-solid border-gray-400 border-2 overflow-hidden rounded-xl shadow-lg shadow-gray-400">
                            <img src="\images\Terrain_synthétique.avif" className="h-full w-full object-cover" alt="Photo terrain"/>
                        </div>
                        
                        <div className="flex flex-row pt-6 gap-4">
                            <div className="flex-1 aspect-[4/3] border-solid border-gray-400 border-2 overflow-hidden rounded-xl shadow-lg shadow-gray-400">
                                <img src="\images\complexe.avif" className="h-full w-full object-cover" alt="Photo complexe"/>
                            </div>
                            <div className="flex-1 aspect-[4/3] border-solid border-gray-400 border-2 overflow-hidden rounded-xl shadow-lg shadow-gray-400">
                                <img src="\images\tribunes.avif" className="h-full w-full object-cover" alt="Photo tribunes"/>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </section>
            <section><News/></section>
        </div>
    
        
    )
}

export default HomePage;
