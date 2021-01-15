import React from "React";

const Iframe = ({
  iframeTitle,
  iframeURL
}) => {
  return (
    <section className={"tq-iframe"}>
      {iframeTitle
        && <h2 className={"iframe-title"}>
          {iframeTitle}
        </h2>}

      {iframeURL
        && <div className={"iframe-container"}>
          <iframe 
            name={"TQ iFrame"}
            className={"iframe-content"} 
            src={iframeURL}
          ></iframe>
        </div>}
    </section>
  );
};

export default Iframe;
