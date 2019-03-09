import style from "./FloorPlanInfo.scss";
import React, { memo, useState } from "react";
import classnames from "classnames";
import printer from "./icons/eleven33-printer.png";
import search from "./icons/eleven33-search.png";
import share from "./icons/eleven33-share.png";
import keyplan from "./icons/Eleven33-Keyplans.png";

const FloorPlanInfo = ({ floorPlan: { post_title, rsf, thumbnail } }) => {
  const [isModalOpen, setModalOpen] = useState(false);
  const toggleModalOpen = () => setModalOpen(!isModalOpen);

  const [isSocialOpen, setSocialOpen] = useState(false);
  const toggleSocialOpen = () => setSocialOpen(!isSocialOpen);

  const { href } = window.location;
  const socials = {
    facebook: encodeURI(`https://www.facebook.com/sharer/sharer.php?u=${href}`),
    twitter: encodeURI(`https://twitter.com/home?status=${href}`),
    pinterest: encodeURI(
      `https://pinterest.com/pin/create/button/?url=${href}&media=${thumbnail}`
    ),
    google: encodeURI(`https://plus.google.com/share?url=${href}`),
    "envelope-o": `mailto:?subject=${post_title}&body=${href}`
  };

  return (
    <div className={classnames("floor-plan-info", style.root)}>
      <div className="floor-plan-info-block floor-plan-name">
        <div className="title">{post_title}</div>
        <div className="rsf">{`${rsf} RSF`}</div>
        <div className="call">Call for availability</div>
      </div>

      <div className="floor-plan-info-block floor-plan-share">
        <div>Share</div>

        <div className="icons-wrapper">
          <a href={thumbnail} target="_blank" referrer="noreferrer noopener">
            <div className="share-icon print">
              <img src={printer} />
            </div>
          </a>

          <div className="share-icon enlarge" onClick={toggleModalOpen}>
            <img src={search} />
          </div>

          <div className={classnames(style.share, "share-icon", "share")}>
            {isSocialOpen && (
              <div
                className={classnames(style.social_wrapper, "social-wrapper")}
              >
                {Object.keys(socials).map(social => (
                  <a
                    href={socials[social]}
                    target="_blank"
                    className={`social-link ${social}`}
                  >
                    <i class={`fa fa-${social} fa-border`} />
                  </a>
                ))}
              </div>
            )}

            <img src={share} onClick={toggleSocialOpen} />
          </div>
        </div>
      </div>

      <div className="floor-plan-info-block floor-plan-key">
        <img src={keyplan} />
      </div>

      {isModalOpen && (
        <div className={style.modal_wrapper} onClick={toggleModalOpen}>
          <div className={style.modal}>
            <img src={thumbnail} />
          </div>
        </div>
      )}
    </div>
  );
};

export default memo(FloorPlanInfo);
